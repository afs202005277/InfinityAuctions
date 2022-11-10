<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_User extends Model
{
    public $timestamps = false;
    // use HasFactory;

    public function bids(){
        return $this->hasMany(Bid::class);
    }

    public function FollowingAuctions(){
        return $this->belongsToMany(Auction::class);
    }

    public function ownedAuctions(){
        return $this->hasMany(Auction::Class);
    }

    public function reportsMade(){
        return $this->hasMany(Report::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function wasReported(){
        return $this->hasMany(Report::class);
    }

    public function reportsHandled(){
        return $this->hasMany(Report::class);
    }
}
