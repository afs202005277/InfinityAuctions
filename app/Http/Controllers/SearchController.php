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
        $filters = $request->input('category.*');
        if(!isset($filters)) {
            $filters = [];
        }

        $auctions = (new Auction())->searchResults($search, $filters);

        return $auctions;
    }
}
