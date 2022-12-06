<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Notification;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auction;
use Log;
use DateTime;

class BidController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
        try{
            $bid = new Bid();
            $this->authorize('create', $bid);
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'auction_id' => 'required|integer',
                'user_id' => 'required|integer'
            ]);

            $auction = Auction::find($validated['auction_id']);

            $bid->amount = $validated['amount'];
            $bid->auction_id = $validated['auction_id'];
            $bid->user_id = $validated['user_id'];
            $id = DB::table('bid')->max('id');
            $bid->id = $id+1;
            $bid->save();
            $bid->name = DB::table('users')->find($bid->user_id)->name;
            $bid->date = DB::table('bid')->find($id+1)->date;

            if ($auction->buy_now) {
                if ($auction->buy_now <= $validated['amount']) {
                    $auction->state = "Ended";
                    $d = new DateTime('now');
                    $dstr = $d->format('Y-m-d H:i:s');
                    $auction->end_date = $dstr;
                    $res = (int) $auction->save();
                }
            }

            $this->addNotification($bid->auction_id);
            return $bid;
        } catch (QueryException $exc){
            return $exc->getMessage();
        }
    }

    public function addNotification($auction_id){
        $biddingUsers = Auction::find($auction_id)->biddingUsers()->get();
        $id = DB::table('notification')->max('id')+1;
        foreach ($biddingUsers as $biddingUser){
            $notification = new Notification();
            $notification->id = $id;
            $notification->type = 'New Bid';
            $notification->user_id = $biddingUser->id;
            $notification->auction_id = $auction_id;
            $notification->save();
            $id++;
        }
    }
}
