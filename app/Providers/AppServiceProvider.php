<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Database\Eloquent\Model;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Keep mass assignment protection ON
        Model::unguard(false);

        // Vite optimization
        Vite::prefetch(concurrency: 3);

        // Globally share auth user with Inertia
        Inertia::share([
            'auth' => [
                'user' => fn () => auth()->user() ? [
                    'id' => auth()->id(),
                    'name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                    'is_admin' => auth()->user()->is_admin,
                ] : null,
            ],
        ]);
    }
}
