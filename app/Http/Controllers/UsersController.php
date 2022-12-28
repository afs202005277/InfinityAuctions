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
        $ratingDetails = $user->getRatingDetails();
        $image = Image::find($user->profile_image)->path;
        return view('pages.users', compact('user', 'ratingDetails', 'image'));
    }

    public function topSellers()
    {
        return User::getUsersWithImages()->paginate(10);
    }
}
