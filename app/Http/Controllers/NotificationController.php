<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Log;

class NotificationController extends Controller
{
    public function addWishListNotification($user_id, $auction_id)
    {
        $notification = new Notification();
        $notification->type = 'Wishlist Targeted';
        $notification->user_id = $user_id;
        $notification->auction_id = $auction_id;
        $notification->save();
    }

    public function getNotifications() {
        $notifications = Notification::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        return view('partials.notifications', compact('notifications'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return string
     */
    public function destroy($id)
    {
        $notification = Notification::find($id);
        try {
            $this->authorize('delete', $notification);
            $notification->delete();
        } catch (AuthorizationException $exception) {
            return response($exception->getMessage(), 403);
        }
        return $notification;
    }
}
