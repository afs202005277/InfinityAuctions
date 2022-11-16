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

    public function mostActive()
    {
        $values = DB::select(DB::raw('SELECT duration_table.*, amount.amount_bids, amount_bids::decimal / to_seconds(duration)::decimal as "rate"
                    FROM (SELECT *, auction.end_date - auction.start_date AS "duration"
                          FROM auction
                          ORDER BY auction.id) AS "duration_table",
                         (SELECT auction_id, count(*) AS "amount_bids" FROM bid GROUP BY auction_id ORDER BY auction_id) AS "amount"
                    WHERE amount.auction_id = duration_table.id AND duration_table.state = \'Running\'
                    ORDER BY rate DESC LIMIT 10;'));
        return $values;
    }

    
    public function refresh()
    {
        DB::raw("UPDATE auction SET state='Ended' WHERE state = 'Running' AND now() > end_date;");
    }

    public function searchResults($search)
    {
        $values = DB::select(DB::raw("SELECT * FROM auction 
                WHERE to_tsvector('english', name || ' ' || description) @@ plainto_tsquery('english', :search);"), 
                array('search' => $search,));

        return $values;

    }

    public function newAuctions()
    {
        $newA = DB::table('auction')
            ->where('state', 'Running')
            ->orderBy('start_date', 'DESC')
            ->limit(10);
        return $newA->get();
    }

    public function runningAuctions()
    {
        return DB::table('auction')
            ->where('state', 'Running')
            ->limit(10)
            ->get();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class);
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
        return $this->hasMany(Report::class);
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
}
