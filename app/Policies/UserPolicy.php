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
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return Auth::check() && (Auth::id() == $model->id || $user->is_admin);
    }

    public function addReview(User $user, $userToRate){
        return Auth::check() && Auth::id() !== $userToRate && !(Auth::user()->is_admin);
    }

    public function showAdminPanel(User $user){
        return Auth::check() && Auth::user()->is_admin;
    }
}
