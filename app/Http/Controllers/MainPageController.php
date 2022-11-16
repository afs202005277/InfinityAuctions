<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;

class MainPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $auctionController = new AuctionController();
        if (Auth::user() !== NULL)
            $selectedAuctions = $auctionController->selectedAuctions();
        else
            $selectedAuctions = (new Auction())->mostActive();
        $mostActive = (new Auction())->mostActive();
        $categories = (new CategoryController())->list();
        $new = (new Auction())->newAuctions();
        return view('pages.main_page', compact('selectedAuctions', 'mostActive', 'categories', 'new'));
    }
}
