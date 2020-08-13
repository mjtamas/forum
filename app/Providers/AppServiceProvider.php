<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
        // \View::composer('*', function ($view) {
        //     $channels = Cache::forever('channels', function () {
        //         return \App\Channel::all();
        //     });
        //     $view->with('channels', $channels);
        // });

        view()->composer('*', function ($view) {
            $channels = Cache::rememberForever('channels', function () {
                return \App\Channel::all();
            });
            $view->with('channels', $channels);
        });

    }
}
