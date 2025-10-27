<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(\App\Http\Middleware\RequestLogger::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
     // we can declare a shared data to the view blade  so we can acessa  from what ever u wna t

     View::share('nameG',"getabalew kemaw amare");
    }
}
