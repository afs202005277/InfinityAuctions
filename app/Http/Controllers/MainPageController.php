<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use Log;
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
        $global_start_time = microtime(true);
        $auctionController = new AuctionController();
        $userController = new UsersController();
        $start_time = microtime(true);
        $selectedAuctions = $auctionController->selectedAuctions();
        $end_time = microtime(true);
        \Log::info('1 '. ($end_time - $start_time));
        $mostActive = Auction::mostActive();
        $categories = Category::all();
        $start_time = microtime(true);
        $topSellers = $userController->topSellers();
        $end_time = microtime(true);
        \Log::info('2 '. ($end_time - $start_time));
        $new = Auction::newAuctions();
        $start_time = microtime(true);
        $view = view('pages.main_page', compact('selectedAuctions', 'mostActive', 'categories', 'new','topSellers'));
        $end_time = microtime(true);
        \Log::info('3 '. ($end_time - $start_time));
        $global_end_time = microtime(true);
        \Log::info('4 '. ($global_end_time - $global_start_time));
        return $view;
    }
}
