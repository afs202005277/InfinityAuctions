<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    public $timestamps = false;
    // use HasFactory;

    public function bids(){
        return $this->hasMany(Bid::class);
    }

    public function followers(){
        return $this->belongsToMany(General_User::class);
    }

    public function owner(){
        return $this->belongsTo(General_User::class, 'auction_owner_id');
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function reports(){
        return $this->hasMany(Report::class);
    }

}
