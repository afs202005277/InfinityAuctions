<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Image extends Model
{
    protected $table = 'image';

    public $timestamps = false;

    public function user(){
        return $this->hasOne(User::class, 'profile_image');
    }

    public function auction(){
        return $this->belongsTo(Auction::class, 'auction_id');
    }
}
