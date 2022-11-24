<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use App\Models\Image;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
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
        $images = $details->images()->get('path');

        return view('pages.auction', compact('auction_id', 'details', 'bids', 'name', 'auctions', 'mostActive', 'images'));
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
            $auction->id = $id + 1;

            $auction->save();

            foreach (Category::all() as $key => $category) {
                if ($request->has($category->name)) {
                    Auction::find($id + 1)->categories()->attach($key + 1);
                }
            }

            $imageController = new ImageController();
            foreach ($request->file('images') as $key => $image) {
                $imageController->store($image, 'AuctionImages/', $auction->id);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $auction = Auction::find($id);

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
     * @return \Illuminate\Http\RedirectResponse
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

            $imageController = new ImageController();
            if ($request->file('images') !== null){
                foreach ($request->file('images') as $image) {
                    $imageController->store($image, 'AuctionImages/', $auction->id);
                }
            }

            // return redirect('auctions/' . $auction->id);
        } catch (AuthorizationException $exception) {
            return redirect()->back()->withErrors("You don't have permissions to edit this auction!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Auction $auction
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        $auction = Auction::find($id);
        try {
            $this->authorize('delete', $auction);

            $auction->state = 'Cancelled';

            $auction->save();
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
}
