<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    protected $table = 'category';

    public $timestamps = false;

    public function auctions(){
        return $this->belongsToMany(Auction::class);
    }

    public static function auction_categories($auction_id) {
        return DB::table('auction')->join('auction_category', 'auction.id', '=', 'auction_category.auction_id')
                            ->join('category', 'auction_category.category_id', '=', 'category.id')
                            ->where('auction_category.auction_id', '=', $auction_id)->select('category.name', 'category.id')->get();
        
        
    }
}
