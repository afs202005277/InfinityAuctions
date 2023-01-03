<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use App\Models\Report;
use App\Models\Report_Option;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $users = User::getUsersWithImages()->paginate(15);
        return view('pages.search_users', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Application|Factory|View
     */
    public function show($id)
    {
        $user = User::find($id);
        $banned = $user->isBanned();
        if ($banned && (!Auth::check() || Auth::id() != $id)){
            return view('pages.banned_page');
        }

        $image = Image::find($user->profile_image)->path;
        $ban_opts = User::getBanStates();

        if($user->is_admin) {
            $usrReports = $user->pendingUsrReports()->get();
            
            $aucReports = $user->pendingAucReports()->get();
            return view('pages.admin', compact('user', 'image', 'usrReports', 'aucReports', 'ban_opts'));
        }

        $ratingDetails = $user->getRatingDetails();
        return view('pages.users', compact('user', 'ratingDetails', 'image', 'banned'));
    }

    public function topSellers()
    {
        return User::getTopSellers();
    }
}
