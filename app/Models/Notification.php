<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;
    // use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id');
    }

    public function report(){
        return $this->belongsTo(Report::class, 'report_id');
    }

}
