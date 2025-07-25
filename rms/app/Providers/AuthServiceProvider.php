<?php

namespace App\Providers;

use App\BoxOwner;
use App\Policies\BoxOwnerPolicy;
use App\Policies\VoyagePolicy;
use App\Policies\YardPolicy;
use App\User;
use App\Voyage;
use App\Yard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        'App\Port::class' => 'App\Policies\PortPolicy::class',
        'App\Vessel::class' => 'App\Policies\VesselPolicy::class',
        'App\Voyage::class' => 'App\Policies\VoyagePolicy::class',
        'App\Yard::class' => 'App\Policies\YardPolicy::class',
        'App\BoxOwner::class' => 'App\Policies\BoxOwnerPolicy::class',
        'App\Container::class' => 'App\Policies\ContainerPolicy::class',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //if user is an admin all are allowed.
        Gate::before(function () {
            if (Auth::guard('admin')->check()) {
                return true;
            }
        });

        //when user is not an admin policies will be applied.
        $this->registerPolicies();

        Gate::define('other_report.index',function ($user){
            return $user->can('other_report');
        });
        Gate::define('mersk_report.index',function ($user){
            return $user->can('mersk_report');
        });
        Gate::define('monitoring_report.index',function ($user){
            return $user->can('monitoring_report');
        });
        Gate::define('missed_monitoring.index',function ($user){
            return $user->can('missed_monitoring');
        });
        Gate::define('monitoring.index',function ($user){
            return $user->can('monitoring');
        });
        Gate::define('master_report.index',function ($user){
            return $user->can('master_report');
        });
        Gate::define('plug_in_list.index',function ($user){
            return $user->can('plug_in_list');
        });
        Gate::define('lock.index',function ($user){
            return $user->can('lock');
        });
        Gate::define('backup.index',function ($user){
            return $user->can('backup');
        });

        //
    }
}
