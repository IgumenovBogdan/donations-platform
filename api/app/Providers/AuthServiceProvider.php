<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Contributor;
use App\Models\Lot;
use App\Models\Organization;
use App\Models\Subscription;
use App\Policies\LotPolicy;
use App\Policies\OrganizationPolicy;
use App\Policies\SubscriptionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Lot::class => LotPolicy::class,
        Organization::class => OrganizationPolicy::class,
        Subscription::class => SubscriptionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
