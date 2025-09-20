<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('movies.create', function (User $user) {
            return ($user->role ?? 'user') === 'admin';
        });

        Gate::define('movies.delete', function (User $user) {
            return ($user->role ?? 'user') === 'admin';
        });
    }
}
