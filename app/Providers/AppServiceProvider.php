<?php

namespace App\Providers;

use App\Enums\RouteModel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        Relation::enforceMorphMap([
            RouteModel::User->value => 'App\Models\User',
            RouteModel::Park->value => 'App\Models\Park',
            RouteModel::Breed->value => 'App\Models\Breed',
        ]);
    }
}
