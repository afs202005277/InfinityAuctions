<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    public $timestamps = false;
    // use HasFactory;

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function bidder(){
        return $this->belongsTo(General_User::class, 'user_id');
    }
}
