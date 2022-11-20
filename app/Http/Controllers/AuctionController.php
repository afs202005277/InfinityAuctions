<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function show($auction_id)
    {
        $details = Auction::find($auction_id);
        $owner = $details->owner()->first();
        $name = $owner->name;
        $auctions = $owner->ownedAuctions()->where('auction.id', '<>', $auction_id)->get();
        $bids = $details->bids()->orderBy('amount')->get();
        $mostActive = (new Auction())->mostActive();
        return view('pages.auction', compact('auction_id', 'details', 'bids', 'name', 'auctions', 'mostActive'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function showSellForm()
    {
        return view('pages.sell');
    }

    public function sell(Request $request)
    {
        $auction = new Auction();

        $postData = $request->only('images');
        $file = $postData['images'];

        $fileArray = array('image' => $file);

        // Tell the validator that this file should be an image
        $rules = array(
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
        );

        // Now pass the input and rules into the validator
        $validator = Validator::make($fileArray, $rules);

        $validated = $request->validate([
            'title' => 'required|min:1|max:255',
            'desc' => 'required|min:1|max:255',
            'baseprice' => 'required|numeric|gt:0',
            'startdate' => 'required|date|after:now',
            'enddate' => 'required|date|after:startdate',
            'buynow' => 'nullable|numeric|gt:baseprice',
        ]);

        $auction->name = $validated['title'];
        $auction->description = $validated['desc'];
        $auction->base_price = $validated['baseprice'];
        $auction->start_date = $validated['startdate'];
        $auction->end_date = $validated['enddate'];
        $auction->buy_now = $validated['buynow'];
        $auction->state = "To be started";
        $auction->auction_owner_id = Auth::user()->id;

        $id = DB::table('auction')->max('id');
        $auction->id = $id+1;

        foreach($request->file('images') as $key => $image)
        {
            $destinationPath = public_path() . '/AuctionImages/';
            $filename = "AUCTION_" . $auction->id . "_" . $key . ".png";
            $image->move($destinationPath, $filename);
        }

        $auction->save();

        return redirect('auctions/' . $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function edit(Auction $auction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Auction $auction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Auction $auction)
    {
        //
    }

    public function selectedAuctions()
    {
        return Auth::user()->followingAuctions()->limit(5)->get();
    }
}
