<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Ini adalah kunci agar middleware can:role bisa jalan
        Gate::define('role', function (User $user, ...$roles) {
            return in_array($user->role, $roles);
        });
    }
}
