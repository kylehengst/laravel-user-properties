<?php

namespace App\Providers;

use App\Events\UserWasCreated;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

use App\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function ($user) {
            Event::fire(new UserWasCreated($user));
//            event(new UserWasCreated($user));
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
