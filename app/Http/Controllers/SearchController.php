<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use App\Models\Category;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        //
    }

    public function search(Request $request)
    {
        
        $search = $request->input('search');
        $filters = $request->input('category.*');
        if(!isset($filters)) {
            $filters = [];
        }

        $auctions = (new Auction())->searchResults($search, $filters);

        $categories = Category::all();

        return view('pages.search_page', compact('auctions', 'filters', 'categories', 'search'));
    }
}
