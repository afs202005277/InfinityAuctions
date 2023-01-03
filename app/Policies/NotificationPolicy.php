<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     * Only the current authenticated user can delete its notifications
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Notification $notification)
    {
        return Auth::check() && Auth::id()==$notification->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     * Only the current authenticated user can delete its notifications
     * @param  \App\Models\User  $user
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Notification $notification)
    {
        return Auth::check();
    }
}
