<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Item' => 'App\Policies\ItemPolicy',
        'App\Models\Bid' => 'App\Policies\BidPolicy',
        'App\Models\Auction' => 'App\Policies\AuctionPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Report_Option' => 'App\Policies\Report_OptionPolicy',
        'App\Models\Report' => 'App\Policies\ReportPolicy',
        'App\Models\Image' => 'App\Policies\ImagePolicy',
        'App\Models\User' => 'App\Policies\UserPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
