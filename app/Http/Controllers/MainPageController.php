<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Models\Category;

class MainPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function __invoke(Request $request)
    {
        $auctionController = new AuctionController();
        $userController = new UsersController();
        $selectedAuctions = $auctionController->selectedAuctions();
        $mostActive = Auction::mostActive();
        $categories = Category::all();
        $topSellers = $userController->topSellers();
        $new = Auction::newAuctions();
        return view('pages.main_page', compact('selectedAuctions', 'mostActive', 'categories', 'new','topSellers'));
    }
}
