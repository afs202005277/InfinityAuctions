<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        
        $order = $request->input('order');
        if(!isset($order)) {
            $order = 1;
        }

        $filters['maxPrice'] = $request->input('filter.maxPrice');
        $filters['buyNow'] = $request->input('filter.buyNow');

        $auctions = (new Auction())->searchResults($search, $filters, $order);

        return $auctions;
    }
}
