<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\CategoryController;

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
        $selectedAuctions = $auctionController->selectedAuctions();
        $mostActive = $auctionController->mostActive();
        $categories = (new CategoryController())->list();
        $new = $auctionController->newAuctions();
        return view('pages.main_page', compact('selectedAuctions', 'mostActive', 'categories', 'new'));
    }
}
