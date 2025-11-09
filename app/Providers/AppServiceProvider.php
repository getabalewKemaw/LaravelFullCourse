<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Contracts\PaymentContract;
use App\Services\StripePaymentService;




class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(\App\Http\Middleware\RequestLogger::class);
        $this->app->bind(PaymentContract::class, StripePaymentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
     // we can declare a shared data to the view blade  so we can acessa  from what ever u wna t


         Gate::define('manage-posts', function ($user) {
        return $user->isAdmin() || $user->role === 'moderator';
    });

     View::share('nameG',"getabalew kemaw amare");
    }
}
