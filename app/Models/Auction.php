<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Helpers\PaginationHelper;
class Auction extends Model
{
    protected $table = 'auction';

    public $timestamps = false;

    public static function attachImages($query)
    {
        return $query->join('image', 'image.auction_id', '=', 'auction.id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function getWinnerPrice()
    {
        return $this->bids()->max('amount');
    }

    public function getWinnerID()
    {
        $maxAmount = $this->getWinnerPrice();
        return $this->bids()->where('amount', $maxAmount)->value('user_id');
    }

    public function biddingUsers()
    {
        return $this->bids()
            ->join('users', 'bid.user_id', '=', 'users.id')
            ->select('users.id')
            ->distinct();
    }

    public static function mostActive()
    {
        // returns the most active running auctions (the ones with the higher rate of bids per second)
        return DB::select(DB::raw('SELECT duration_table.*, amount.amount_bids, amount_bids::decimal / to_seconds(duration)::decimal as "rate"
                    FROM (SELECT *, auction.end_date - auction.start_date AS "duration"
                          FROM auction
                          ORDER BY auction.id) AS "duration_table",
                         (SELECT auction_id, count(*) AS "amount_bids" FROM bid GROUP BY auction_id ORDER BY auction_id) AS "amount"
                    WHERE amount.auction_id = duration_table.id AND duration_table.state = \'Running\'
                    ORDER BY rate DESC;'));
    }

    public static function toEndAuctions()
    {
        return DB::select(DB::raw("SELECT * FROM auction WHERE state = 'Running' AND to_char(now(), 'YYYY-MM-DD:HH24:MI') = to_char(end_date, 'YYYY-MM-DD:HH24:MI');"));
    }

    public static function nearEndAuctions()
    {
        return DB::select(DB::raw("SELECT * FROM auction WHERE state = 'Running' AND to_char(now() + interval '1 hour', 'YYYY-MM-DD:HH24:MI') = to_char(end_date, 'YYYY-MM-DD:HH24:MI');"));
    }

    public static function updateStates()
    {
        DB::select(DB::raw("UPDATE auction SET state='Ended' WHERE state = 'Running' AND now() > end_date;"));
        DB::select(DB::raw("UPDATE auction SET state='Running' WHERE state = 'To be started' AND now() >= start_date;"));
    }

    public static function searchResults($search, $filters, $order)
    {
        $query = DB::table('auction')
            ->selectRaw('auction.*,
                        CASE
                            WHEN bool_and(rates.id_seller IS NOT NULL) THEN AVG(rates.rate)::NUMERIC(10,2)
                            ELSE 0
                        END AS average_rate,
                        CASE
                            WHEN bool_and(bid.auction_id IS NOT NULL) THEN MAX(bid.amount)
                            ELSE auction.base_price
                        END AS max_price
                        ')
            ->join('auction_category', 'auction.id', '=', 'auction_category.auction_id')
            ->join('category', 'auction_category.category_id', '=', 'category.id')
            ->leftjoin('rates', 'auction.auction_owner_id', '=', 'rates.id_seller')
            ->leftjoin('bid', 'auction.id', '=', 'bid.auction_id');

        if (count($filters['category'])) {
            $query->whereIn('category.id', $filters['category']);
        }

        if (count($filters['state'])) {
            $query->whereIn('auction.state', $filters['state']);
        }

        if (isset($filters['buyNow'])) {
            $query->whereRaw("auction.buy_now IS NOT NULL");
        }

        if (isset($search)) {
            $query->whereRaw("auction_tokens @@ plainto_tsquery('english', ?)", [$search]);
        }

        $query->groupBy('auction.auction_owner_id');
        $query->groupBy('auction.id');

        if ($order == 1 && isset($search)) {
            $query->orderByRaw("ts_rank(auction_tokens, plainto_tsquery('english', ?)) DESC", [$search]);
        } elseif ($order == 2) {
            $query->orderByRaw('max_price DESC');
        } elseif ($order == 3) {
            $query->orderByRaw('max_price ASC');
        } elseif ($order == 4) {
            $query->orderByRaw('average_rate DESC');
        }

        $values = $query->get();

        if (isset($filters['maxPrice'])) {
            $values = $values->where('max_price', '<=', $filters['maxPrice']);
            return PaginationHelper::paginate($values, 10)->withQueryString();
        }

        return PaginationHelper::paginate($values, 10)->withQueryString();

    }

    public static function newAuctions()
    {
        $newA = DB::table('auction')
            ->select('auction.*')
            ->where('state', 'Running')
            ->orderBy('start_date', 'DESC');
        return $newA->get();
    }

    public function biddersAndFollowers()
    {
        $biddingUsers = $this->biddingUsers()->select('user_id as id');
        $followingUsers = $this->followers()->select('user_id as id');
        return $biddingUsers
            ->union($followingUsers)
            ->distinct();
    }

    public function followsAuction($user_id)
    {
        return $this->followers()->where('user_id', '=', $user_id)->get();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'following');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'auction_owner_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'auction_reported');
    }

    public function getAllBids($id)
    {
        return DB::table('users')
            ->join('bid', 'users.id', '=', 'bid.user_id')
            ->where('auction_id', '=', $id)
            ->select('users.name', 'bid.*')
            ->orderBy('amount', 'DESC')
            ->get();
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'auction_id');
    }

    public static function returnStates()
    {
        return DB::select(DB::raw("SELECT unnest(enum_range(NULL::auction_possible_state))::text AS type;"));
    }
}
