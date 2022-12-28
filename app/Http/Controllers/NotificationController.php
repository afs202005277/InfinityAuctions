<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

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
