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
        $filters['category'] = $request->input('filter.category.*');
        if(!isset($filters['category'])) {
            $filters['category'] = [];
        }

        $filters['state'] = $request->input('filter.state.*');
        if(!isset($filters['state'])) {
            $filters['state'] = [];
        }

        $filters['maxPrice'] = $request->input('filter.maxPrice');

        $auctions = (new Auction())->searchResults($search, $filters);

        return $auctions;
    }
}
