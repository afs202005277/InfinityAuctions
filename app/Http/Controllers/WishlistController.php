<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function follow_term(Request $request)
    {
        $wishlist_id = Wishlist::getIdForSearch($request->search);
        $user_id = Auth::id();
        if (!Wishlist::follows($request->search)) {
            $data = array('users_id' => $user_id, 'wishlist_id' => $wishlist_id);
            Wishlist::insertUsersWishlist($data);
            return response('Success', 204);
        } else {
            return response('Already exists', 409);
        }
    }

    public function unfollow_term(Request $request)
    {
        $wishlist_id = Wishlist::getIdForSearch($request->search);
        $user_id = Auth::id();
        if (!Wishlist::follows($request->search)) {
            return response('Doesn\'t exist', 404);
        } else {
            Wishlist::removeUsersWishlist($user_id, $wishlist_id);
            return response('Success', 204);
        }
    }
}

