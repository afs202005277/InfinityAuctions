<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Srkmlive\Payments\Facades\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;

use DateTime;
use Log;

class PayPalController extends Controller

{
/**
 * Responds with a welcome message with instructions
 *
 * @return \Illuminate\Http\Response
 */

    public function show()
    {
        if (!Auth::id()) {
            return redirect('/login');
        }

        $balance = User::getBalance(Auth::id());
        $heldBalance = User::heldBalance(Auth::id());
        return view('pages.balance', compact('balance', 'heldBalance'));
    }

    public function payment(Request $request)
    {
        if (!Auth::id()) {
            return redirect('/login');
        }

        try {

            $validated = $request->validate([
                'deposit' => 'required|min:5|numeric|max:9999999.99',
                ]);

            $provider = new PayPalClient;

            // Through facade. No need to import namespaces
            $provider = \PayPal::setProvider();
            $provider->getAccessToken();

            $data = [
                "intent"              => "CAPTURE",
                "purchase_units"      => [
                    [
                        "amount" => [
                            "value"         => $validated['deposit'],
                            "currency_code" => "EUR",
                        ],
                    ],
                ],
                "application_context" => [
                    "cancel_url" => route('deposit.cancel'),
                    "return_url" => route('deposit.success'),
                ],
            ];
            
            $order = $provider->createOrder($data);

            return redirect($order['links'][1]['href']);

        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors("Invalid database parameters!");
        }
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function cancel()
    {
        $cancel = "Order cancelled.";
        return view('pages.balance', compact('cancel'));
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function success(Request $request)
    {
        $provider = new PayPalClient;      // To use express checkout.
        $provider->getAccessToken();
        $token = $request->get('token');

        $orderInfo = $provider->showOrderDetails($token);
        $response = $provider->capturePaymentOrder($token);

        if (!($response["purchase_units"][0]["payments"]["captures"][0]["amount"]["value"] ?? null)) {
            $balance = User::getBalance(Auth::id());
            $fail = "Order was not completed. Please try again.";
            return view('pages.balance', compact('balance', 'fail'));
        }

        if ($response["purchase_units"][0]["payments"]["captures"][0]["amount"]["value"]) {
            User::addBalance(Auth::id(), (float) $response["purchase_units"][0]["payments"]["captures"][0]["amount"]["value"]);
            $balance = User::getBalance(Auth::id());
            $succ = "Credits successfully added.";
            return view('pages.balance', compact('balance', 'succ'));
        }
        
    }

    private function generatePayoutID() {
        // generate 32 random bytes
        $bytes = random_bytes(8);

        // convert the bytes to a hexadecimal string
        $hex = bin2hex($bytes);

        Log::info($hex);
        // return the string as the random ID
        return $hex;
    }



    public function withdraw(Request $request)
    {
        if (!Auth::id()) {
            return redirect('/login');
        }

        $balance = User::getBalance(Auth::id());
        $heldBalance = User::heldBalance(Auth::id());

        try {

            $validated = $request->validate([
                'withdraw' => 'required|min:5|numeric|max:9999999.99',
            ]);

            if ($balance - $heldBalance - $validated['withdraw'] < 0) {
                $cancel = "Not enough available capital.";
                $balance = User::getBalance(Auth::id());
                $heldBalance = User::heldBalance(Auth::id());
                return view('pages.balance', compact('balance', 'heldBalance', 'cancel'));
            }
            
            $provider = new PayPalClient;

            // Through facade. No need to import namespaces
            $provider = \PayPal::setProvider();
            $token = $provider->getAccessToken();

            $data = [
                "sender_batch_header" => [
                    "sender_batch_id" => $this->generatePayoutID(),
                    "email_subject" => "Infinity Auction Withdraw Payout!",
                    "email_message" => "You have received a payout! Thanks for using our service!"
                ],
                "items" => [
                    [
                        "recipient_type" => "EMAIL",
                        "amount"    => [
                            "value"         => $validated['withdraw'],
                            "currency" => "EUR"
                            ],
                        "receiver" => User::find(Auth::id())->email,
                        "sender_item_id" => "696980085"
                    ],
                ],
                "application_context" => [
                    "cancel_url" => route('withdraw.cancel'),
                    "return_url" => route('withdraw.success')
                ],
            ];

            Log::info($data);

            $payout = $provider->createBatchPayout($data);

            Log::info($payout);

            if (isset($payout['links'][0]['href'])) {
                return $this->withdrawSuccess($validated['withdraw']);
            } else {
                return $this->withdrawCancel();
            }

            return redirect($payout['links'][0]['href'])->header('content-type', 'application/json')->header('authorization', 'Bearer ' . $token['access_token']);
            
        } catch (QueryException $sqlExcept) {
            return redirect()->back()->withErrors("Invalid database parameters!");
        }
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function withdrawCancel()
    {
        $balance = User::getBalance(Auth::id());
        $heldBalance = User::heldBalance(Auth::id());
        $cancel = "Payout failed.";
        return view('pages.balance', compact('balance', 'heldBalance', 'cancel'));
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */

    public function withdrawSuccess($amount)
    {
        User::removeBalance(Auth::id(), $amount);
        $balance = User::getBalance(Auth::id());
        $heldBalance = User::heldBalance(Auth::id());
        $succ = "Mail was sent confirming withdrawal. Credits successfully withdrawn.";
        return view('pages.balance', compact('balance', 'heldBalance', 'succ'));
        
    }
}