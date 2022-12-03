<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\SearchController;

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

        $auctions = (new SearchController())->search($request);

        $categories = Category::all();
        $states = (new Auction())->returnStates();

        return view('pages.search_page', compact('auctions', 'states', 'filters', 'categories', 'search'));
    }
}
