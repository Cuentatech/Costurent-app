<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Define roles personalizados para autorización
        Gate::define('admin', function ($user) {
            return $user->rol === 'administrador';
        });

        Gate::define('cliente', function ($user) {
            return $user->rol === 'cliente';
        });
    }
}
