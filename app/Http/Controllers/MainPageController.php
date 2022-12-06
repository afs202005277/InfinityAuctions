<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use App\Http\Controllers\AuctionController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;

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
        $mostActive = (new Auction())->mostActive();
        $categories = (new CategoryController())->list();
        $topSellers = $userController->topSellers();
        \Log::info($topSellers);
        $new = (new Auction())->newAuctions();
        return view('pages.main_page', compact('selectedAuctions', 'mostActive', 'categories', 'new','topSellers'));
    }
}
