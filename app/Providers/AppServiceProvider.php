<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            \App\Repositories\Dashboard\Shipment\ShipmentRepositoryInterface::class,
            \App\Repositories\Dashboard\Shipment\ShipmentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Dashboard\Admin\Role\RoleRepositoryInterface::class,
            \App\Repositories\Dashboard\Admin\Role\RoleRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Dashboard\Admin\Permission\PermissionRepositoryInterface::class,
            \App\Repositories\Dashboard\Admin\Permission\PermissionRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Dashboard\Admin\User\UserRepositoryInterface::class,
            \App\Repositories\Dashboard\Admin\User\UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Implicitly grant "super_admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user()->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
