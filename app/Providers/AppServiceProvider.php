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
        $bindings = [
            \App\Repositories\Dashboard\Merchant\Shipment\ShipmentRepositoryInterface::class => \App\Repositories\Dashboard\Merchant\Shipment\ShipmentRepository::class,
            \App\Repositories\Dashboard\Admin\Shipment\ShipmentRepositoryInterface::class => \App\Repositories\Dashboard\Admin\Shipment\ShipmentRepository::class,
            \App\Repositories\Dashboard\Driver\Shipment\ShipmentRepositoryInterface::class => \App\Repositories\Dashboard\Driver\Shipment\ShipmentRepository::class,
            \App\Repositories\Dashboard\Admin\Role\RoleRepositoryInterface::class => \App\Repositories\Dashboard\Admin\Role\RoleRepository::class,
            \App\Repositories\Dashboard\Admin\Permission\PermissionRepositoryInterface::class => \App\Repositories\Dashboard\Admin\Permission\PermissionRepository::class,
            \App\Repositories\Dashboard\Admin\User\UserRepositoryInterface::class => \App\Repositories\Dashboard\Admin\User\UserRepository::class,
        ];

        foreach ($bindings as $interface => $implementation) {
            $this->app->singleton($interface, $implementation);
        }
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Shipment::observe(\App\Observers\ShipmentObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);

        // Implicitly grant "super_admin" role all permissions
        // This works in the app by using gate-related functions like auth()->user()->can() and @can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });
    }
}
