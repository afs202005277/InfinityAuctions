<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    protected $table = 'wishlist';

    public static function follows($search)
    {
        $wishlist_id = Wishlist::getIdForSearch($search);
        if (!Auth::id()) {
            return False;
        }
        $user_id = Auth::id();
        $check = DB::select(DB::raw("SELECT * FROM users_wishlist WHERE users_id = " . $user_id . " AND wishlist_id = " . $wishlist_id . ";"));
        return !empty($check);
    }

    public static function getIdForSearch($search)
    {
        $wishlist = DB::select(DB::raw("SELECT * FROM wishlist WHERE name = '" . $search . "';"));
        if (empty($wishlist)) {
            $id = Wishlist::max('id') + 1;
            $data = array('id' => $id, 'name' => $search);
            DB::table('wishlist')->insert($data);
            return Wishlist::max('id');
        } else {
            return $wishlist[0]->id;
        }
    }

    public static function insertUsersWishlist($data)
    {
        DB::table('users_wishlist')->insert($data);
    }

    public static function removeUsersWishlist($user_id, $wishlist_id)
    {
        DB::table('users_wishlist')->where('users_id', $user_id)->where('wishlist_id', $wishlist_id)->delete();
    }
}
