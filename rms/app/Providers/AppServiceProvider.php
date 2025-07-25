<?php

namespace App\Providers;

use App\Observers\PortObserver;
use App\Port;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Port::observe(PortObserver::class);

        Schema::defaultStringLength(191);
    }
}
