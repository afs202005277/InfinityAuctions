<?php

namespace App\Policies;

use App\Models\Bid;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class BidPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     * Any authenticated user that is not banned and is not an admin can make a bid.
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return Auth::check() && !$user->isBanned() && !$user->is_admin;
    }
}
