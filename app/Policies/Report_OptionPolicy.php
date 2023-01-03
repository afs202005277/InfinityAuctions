<?php

namespace App\Policies;

use App\Models\Report_Option;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Report_OptionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     * Only admins can manage report options
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     * Only admins can manage report options
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report_Option  $reportOption
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Report_Option $reportOption)
    {
        return $user->is_admin;
    }
}
