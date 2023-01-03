<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the model.
     * Only the auction's owner or an admin can delete an image
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Image $image)
    {
        return Auth::check() && ($user->is_admin || ($user->id == $image->auction()->value('auction_owner_id') && $image->auction()->value('state') != 'Canceled' && $image->auction()->value('state') != 'Ended'));
    }
}
