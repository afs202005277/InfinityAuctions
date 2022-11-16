<?php

namespace App\Http\Controllers;
use App\Models\Auction;

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

        $auctions = (new Auction())->searchResults($search);

        return view('pages.search_page', compact('auctions'));
    }
}
