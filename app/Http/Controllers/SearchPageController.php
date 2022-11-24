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
        $filters = $request->input('category.*');
        if(!isset($filters)) {
            $filters = [];
        }

        $auctions = (new SearchController())->search($request);

        $categories = Category::all();

        return view('pages.search_page', compact('auctions', 'filters', 'categories', 'search'));
    }
}
