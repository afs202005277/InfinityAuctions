<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;

class ManageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('pages.admin_panel');
    }
}
