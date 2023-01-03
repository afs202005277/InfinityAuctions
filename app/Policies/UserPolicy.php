<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     * Only the user or an admin can update the user account.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        return Auth::check() && (Auth::user()->id == $model->id || $model->is_admin);
    }

    /**
     * Determine whether the user can delete the model.
     * Only the user or an admin can delete the user account.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return Auth::check() && (Auth::id() == $model->id || $user->is_admin);
    }

    /**
     * Only users that are not admins can make a rate of other users (never about himself)
     *
     * @param User $user
     * @param $userToRate
     * @return bool
     */
    public function addReview(User $user, $userToRate){
        return Auth::check() && Auth::id() !== $userToRate && !(Auth::user()->is_admin);
    }
}
