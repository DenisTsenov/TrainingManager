<?php

namespace App\Providers;

use App\Models\Admin\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
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
        Blade::if('admin', function () {
            return Auth::user()->is_admin ?? null;
        });

        Blade::if('trainer', function () {
            return Auth::user()->role_id == Role::TRAINER;
        });

        Blade::if('competitor', function () {
            return Auth::user()->role_id == Role::COMPETITOR;
        });

        Model::preventLazyLoading(!$this->app->isProduction());
    }
}
