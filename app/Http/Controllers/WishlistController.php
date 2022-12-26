<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use Log;

class WishlistController extends Controller
{

    public function follow_term(Request $request) {
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

    public function unfollow_term(Request $request) {
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

