<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('superAdmin', function ($user) {
            return $user->username == "admin" ? Response::allow() : Response::deny('You must be an admin to acces this endpoint');
        });

        Gate::define('superAdminOrAdminUser', function ($user) {
            return $user->username == "admin" || $user->isAdmin() ? Response::allow() : Response::deny('You must be an admin or an adminUser to acces this endpoint');
        });

        Gate::define('superAdminOrRegisteredUser', function ($user) {
            return $user->username == "admin" || $user->isRegistered() ? Response::allow() : Response::deny('You must be an admin or a registeredUser to acces this endpoint');
        });

        Gate::define('adminUser', function ($user) {
            return $user->isAdmin() ? Response::allow() : Response::deny('You must be an adminUser to acces this endpoint');
        });

        Gate::define('registeredUser', function ($user) {
            return $user->isRegistered() ? Response::allow() : Response::deny('You must be a registeredUser to acces this endpoint');
        });
    }
}
