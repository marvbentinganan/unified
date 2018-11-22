<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->composer('layouts.app', function ($view) {
            $role = auth()->user()->roles()->first();
            $menus = $role->menus->where('is_primary', true)->sortBy('order');
            $view->with(compact('menus'));
        });
    }

    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
