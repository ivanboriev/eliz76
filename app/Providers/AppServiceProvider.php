<?php

namespace App\Providers;

use App\Cluster;
use App\Shield;
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

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Cluster::deleted(function ($cluster) {
            $cluster->shields()->delete();
        });

        Shield::deleted(function ($shield) {
            $shield->groups()->delete();
        });
    }

}
