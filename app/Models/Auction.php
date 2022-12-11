<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Auction extends Model
{
    protected $table = 'auction';

    public $timestamps = false;

    // use HasFactory;

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function getWinnerID(){
        $maxAmount = $this->bids()->max('amount');
        return $this->bids()->where('amount', $maxAmount)->value('user_id');
    }

    public function biddingUsers()
    {
        return $this->bids()
            ->join('users', 'bid.user_id', '=', 'users.id')
            ->select('users.id')
            ->distinct();
    }

    public function mostActive()
    {
        $values = DB::select(DB::raw('SELECT duration_table.*, amount.amount_bids, amount_bids::decimal / to_seconds(duration)::decimal as "rate"
                    FROM (SELECT *, auction.end_date - auction.start_date AS "duration"
                          FROM auction
                          ORDER BY auction.id) AS "duration_table",
                         (SELECT auction_id, count(*) AS "amount_bids" FROM bid GROUP BY auction_id ORDER BY auction_id) AS "amount"
                    WHERE amount.auction_id = duration_table.id AND duration_table.state = \'Running\'
                    ORDER BY rate DESC;'));
        return $values;
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

    public function searchResults($search, $filters)
    {
        $query = DB::table('auction')
            ->select('auction.*')
            ->join('auction_category', 'auction.id', '=', 'auction_category.auction_id')
            ->join('category', 'auction_category.category_id', '=', 'category.id');
        if (count($filters)) {
            $query->whereIn('category.id', $filters);
        }

        if (isset($search)) {
            $query->whereRaw("auction_tokens @@ plainto_tsquery('english', ?)", [$search]);
            $query->orderByRaw("ts_rank(auction_tokens, plainto_tsquery('english', ?)) DESC", [$search]);
        }

        //$values = DB::select(DB::raw("SELECT * FROM auction
        //       WHERE auction_tokens @@ plainto_tsquery('english', :search)
        //       ORDER BY ts_rank(auction_tokens, plainto_tsquery('english', :search)) DESC;"),
        //       array('search' => $search,));

        $query->groupBy('auction.id');
        $values = $query->get();

        return $values;
    }

    public function newAuctions()
    {
        $newA = DB::table('auction')
            ->select('auction.*')
            ->where('state', 'Running')
            ->orderBy('start_date', 'DESC');
        return $newA->get();
    }

    public function runningAuctions()
    {
        return DB::table('auction')
            ->where('state', 'Running')
            ->get();
    }

    public function biddersAndFollowers(){
        $biddingUsers =$this->biddingUsers()->select('user_id as id');
        $followingUsers =$this->followers()->select('user_id as id');
        return $biddingUsers
            ->union($followingUsers)
            ->distinct();
    }

    public function followsAuction($user_id){
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
}
