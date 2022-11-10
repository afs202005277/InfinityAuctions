<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public $timestamps = false;
    // use HasFactory;

    public function reporter(){
        return $this->belongsTo(General_User::class, 'reporter');
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

    public function reportOptions(){
        return $this->belongsToMany(Report::class);
    }

    public function reportedUser(){
        return $this->belongsTo(General_User::class, 'reported_user');
    }

    public function reportedAuction(){
        return $this->belongsTo(Auction::class, 'auction_reported');
    }

    public function handledBy(){
        return $this->belongsTo(General_User::class, 'admin_id');
    }
}
