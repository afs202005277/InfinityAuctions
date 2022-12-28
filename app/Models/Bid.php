<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bid extends Model
{
    protected $table = 'bid';

    public $timestamps = false;

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function bidder(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function all_bids($auction_id) {
        return DB::select(DB::raw("SELECT * FROM bid WHERE auction_id = " . $auction_id . " ORDER BY amount DESC;"));
    }
}
