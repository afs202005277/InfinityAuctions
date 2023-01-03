<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     * Only admins can view reports
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can create models.
     * Only non banned users and admins can create reports
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create($user)
    {
        return !$user->isBanned();
    }

    /**
     * Determine whether the user can update the model.
     * Only admins can make changes to reports
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Report $report)
    {
        return $user->is_admin && ($report->admin_id == $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     * Only admins can make delete reports
     * @param  \App\Models\User  $user
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Report $report)
    {
        return $user->is_admin && ($report->admin_id == $user->id);
    }
}
