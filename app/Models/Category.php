<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    public $timestamps = false;
    // use HasFactory;

    public function auctions(){
        return $this->belongsToMany(Auction::class);
    }
}
