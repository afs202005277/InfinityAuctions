<?php

namespace App\Policies;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class AuctionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     * Any authenticated user can create auctions if is is not banned
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Auth::check() && !$user->isBanned() && !$user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Auction $auction)
    {
        return Auth::check() && $user->id == $auction->owner()->get() && $auction->state != 'Canceled' && $auction->state != 'Ended';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Auction  $auction
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Auction $auction)
    {
        return Auth::check() && ($user->id == $auction->owner()->get() || $user->is_admin);
    }
}
