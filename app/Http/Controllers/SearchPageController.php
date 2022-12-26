<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;
use App\Models\Wishlist;

class SearchPageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $search = $request->input('search');
        $filters['category'] = $request->input('filter.category.*');
        if(!isset($filters['category'])) {
            $filters['category'] = [];
        }

        $filters['state'] = $request->input('filter.state.*');
        if(!isset($filters['state'])) {
            $filters['state'] = [];
        }

        $filters['maxPrice'] = $request->input('filter.maxPrice');
        $filters['buyNow'] = $request->input('filter.buyNow');
        $order = $request->input('order');
        if(!isset($order)) {
            $order = 1;
        }
        
        $auctions = (new SearchController())->search($request);

        $categories = Category::all();
        $states = (new Auction())->returnStates();

        $follows = Wishlist::follows($search);

        return view('pages.search_page', compact('auctions', 'states', 'filters', 'order', 'categories', 'search', 'follows'));
    }
}
