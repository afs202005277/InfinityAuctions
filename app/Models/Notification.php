<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notification extends Model
{
    protected $table = 'notification';

    public $timestamps = false;
    // use HasFactory;

    public function getNextId(){
        return DB::table('notifications')->max('id')+1;
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id')->get();
    }

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id')->get();
    }

    public function report(){
        return $this->belongsTo(Report::class, 'report_id')->get();
    }
}
