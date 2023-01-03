<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Auction;
use App\Models\User;
use Log;
use DateTime;

class BidController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return string
     * @throws AuthorizationException
     */
    public function store(Request $request)
    {
        try {
            $bid = new Bid();
            $this->authorize('create', $bid);
            $validated = $request->validate([
                'amount' => 'required|numeric',
                'auction_id' => 'required|integer',
                'user_id' => 'required|integer'
            ]);

            $auction = Auction::find($validated['auction_id']);

            if (User::getBalance($validated['user_id']) - User::heldBalance($validated['user_id']) < $validated['amount']) {
                return response()->json([
                    'ms' => 'Not enough balance.'
                ]);
            }
            \Log::info("Controlo");
            $bid->amount = $validated['amount'];
            $bid->auction_id = $validated['auction_id'];
            $bid->user_id = $validated['user_id'];
            $bid->save();
            $bid->name = DB::table('users')->find($bid->user_id)->name;
            $bid->date = DB::table('bid')->find($bid->id)->date;

            $this->addNewBidNotification($auction->id);
            if ($auction->buy_now) {
                \Log::info("ola");
                if ((float) $auction->buy_now <= (float) $validated['amount']) {
                    \Log::info("INside");
                    $d = new DateTime('now');
                    $dstr = $d->format('Y-m-d H:i:s');
                    $auction->end_date = $dstr;
                    $auction->save();
                }
            }
            if ($auction->bids()->get()->count() !== 1)
                $this->addNotification($bid->auction_id, $bid->user_id);
            return $bid;
        } catch (QueryException $exc) {
            return $exc->getMessage();
        }
    }

    public function addNotification($auction_id, $except_user_id)
    {
        $biddingUsers = Auction::find($auction_id)->biddingUsers()->get();
        foreach ($biddingUsers as $biddingUser) {
            // NAO ALTERAR O LOOP!! OS IF  ESTAO #cursed
            if ($biddingUser->id == $except_user_id) {
                continue;
            } else {
                $notification = new Notification();
                $notification->type = 'Outbid';
                $notification->user_id = $biddingUser->id;
                $notification->auction_id = $auction_id;
                $notification->save();
            }
        }
    }

    public function addNewBidNotification($auction_id){
        $owner = Auction::find($auction_id)->owner()->value('id');;

        $notification = new Notification();
        $notification->type = 'New Bid';
        $notification->user_id = $owner;
        $notification->auction_id = $auction_id;
        $notification->save();
    }
}
