<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use App\Models\Image;
use App\Models\Notification;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Log;

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
        $images = $details->images()->get('path');
        $ratingDetails = $owner->getRatingDetails();
        return view('pages.auction', compact('auction_id', 'details', 'bids', 'name', 'auctions', 'mostActive', 'images', 'ratingDetails'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function showSellForm()
    {
        $categories = Category::all();
        $this->authorize('create', new Auction());
        return view('pages.sell', compact('categories'));
    }

    public function sell(Request $request)
    {
        $auction = new Auction();

        try {
            $this->authorize('create', $auction);
            $postData = $request->only('images');
            $file = $postData['images'];

            $fileArray = array('image' => $file);

            $rules = array(
                'image' => 'mimes:jpeg,jpg,png,gif|required'
            );

            $validator = Validator::make($fileArray, $rules);

            $validated = $request->validate([
                'title' => 'required|min:1|max:255',
                'desc' => 'required|min:1|max:255',
                'images' => 'required|array|min:3',
                'baseprice' => 'required|numeric|gt:0',
                'startdate' => 'required|date|after_or_equal:' . (new \DateTime('now'))->format('m/d/Y'),
                'enddate' => 'required|date|after:startdate',
                'buynow' => 'nullable|numeric|gt:baseprice'
            ], [ 'buynow.gt' => 'The "buy now" value must be greater than the base price.']);

            $auction->name = $validated['title'];
            $auction->description = $validated['desc'];
            $auction->base_price = $validated['baseprice'];
            $auction->start_date = $validated['startdate'];
            $auction->end_date = $validated['enddate'];
            $auction->buy_now = $validated['buynow'];
            $auction->state = "To be started";
            $auction->auction_owner_id = Auth::user()->id;

            $id = DB::table('auction')->max('id');
            $auction->id = $id + 1;

            $auction->save();

            foreach (Category::all() as $key => $category) {
                $cat = str_replace(' ', '', $category->name);
                if ($request->has($cat)) {
                    Auction::find($id + 1)->categories()->attach($key + 1);
                }
            }

            foreach ($request->file('images') as $key => $image) {
                ImageController::store($image, 'AuctionImages/', $auction->id);
            }

            return redirect('auctions/' . $auction->id);
        } catch (AuthorizationException $exception) {
            return redirect('sell')->withErrors("You don't have permissions to create an auction!");
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors("Invalid database parameters!");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Auction $auction
     * @return Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $auction = Auction::find($id);
        $this->authorize('update', $auction);
        return view('pages.sell')
            ->with('title', $auction->name)
            ->with('desc', $auction->description)
            ->with('baseprice', $auction->base_price)
            ->with('startdate', $auction->start_date)
            ->with('enddate', $auction->end_date)
            ->with('buynow', $auction->buy_now)
            ->with('auction_id', $auction->id)
            ->with('categories', Category::all())
            ->with('categoriesChosen', $auction->categories()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Auction $auction
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $auction = Auction::find($id);
            $this->authorize('update', $auction);
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

            $auction->save();

            $ids = array();
            foreach (Category::all() as $key => $category) {
                $cat = str_replace(' ', '', $category->name);
                if ($request->has($cat)) {
                    $ids[] = $category->id;
                }
            }
            if (count($ids) > 0)
                $auction->categories()->sync($ids);

            if ($request->file('images') !== null){
                foreach ($request->file('images') as $image) {
                    ImageController::store($image, 'AuctionImages/', $auction->id);
                }
            }

            return redirect('auctions/' . $auction->id);
        } catch (AuthorizationException $exception) {
            return redirect()->back()->withErrors("You don't have permissions to edit this auction!");
        }
    }

    public static function addNotificationsAuction($auction_id, $type){
        $auction = Auction::find($auction_id);
        if ($type === 'Auction Canceled')
            $biddingUsers =  $auction->biddersAndFollowers()->get();
        else
            $biddingUsers = $auction->biddingUsers()->get();

        $id = DB::table('notification')->max('id')+1;
        foreach ($biddingUsers as $biddingUser){
            $notification = new Notification();
            $notification->id = $id;
            if ($type == 'Auction Ended' && $auction->getWinnerID() == $biddingUser->id)
                $notification->type = 'Auction Won';
            else
                $notification->type = $type;
            $notification->user_id = $biddingUser->id;
            $notification->auction_id = $auction_id;
            $notification->save();
            $id++;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Auction $auction
     * @return Application|RedirectResponse|Redirector
     */
    public function cancel($id)
    {
        $auction = Auction::find($id);
        try {
            $this->authorize('delete', $auction);

            $auction->state = 'Cancelled';

            $auction->save();

            AuctionController::addNotificationsAuction($auction->id, 'Auction Canceled');
            return redirect('/');
        } catch (AuthorizationException $exception) {
            return redirect('auctions/' . $id)->withErrors("You don't have permissions to cancel this auction! ");
        }
    }

    public function selectedAuctions()
    {
        if (Auth::user() === NULL)
            return NULL;
        return Auth::user()->followingAuctions()->get();
    }

    public function getAllBids($auction_id)
    {
        return (new Auction())->getAllbids($auction_id);
    }

    public function endAuction($auction_id)
    {
        $auction = Auction::find($auction_id);
        $auction->end_date = new DateTime('now');
        $auction->save();
    }

    public static function updateAuctionsState(){
        $auctionsToEnd = Auction::toEndAuctions();
        foreach ($auctionsToEnd as $auction) {
            AuctionController::addNotificationsAuction($auction->id, 'Auction Ended');
            $all_bids = Bid::all_bids($auction->id);
            $max_bid = $all_bids[0];
            $amount = $max_bid->amount;
            $user_id = $max_bid->user_id;
            User::removeBalance($user_id, (float) $amount);
            User::addBalance($auction->auction_owner_id, $amount*0.95);
            User::addBalance(1003, $amount*0.05);
        }
        $auctionsEnding = Auction::nearEndAuctions();
        foreach ($auctionsEnding as $auction){
            AuctionController::addNotificationsAuction($auction->id, 'Auction Ending');
        }
        Auction::updateStates();
    }
}
