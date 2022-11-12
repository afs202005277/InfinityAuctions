<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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
