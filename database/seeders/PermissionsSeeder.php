<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserType;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Define distinct permissions for each role
        $adminPermissions = [
            'manage system',
            'manage users',
            'manage all shipments',
        ];

        $merchantPermissions = [
            'create shipments',
            'view own shipments',
        ];

        $driverPermissions = [
            'view assigned shipments',
            'update shipment status',
        ];

        $allPermissions = array_merge($adminPermissions, $merchantPermissions, $driverPermissions);

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create Roles and Assign Explicit Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($adminPermissions);

        $merchantRole = Role::firstOrCreate(['name' => 'merchant']);
        $merchantRole->syncPermissions($merchantPermissions);

        $driverRole = Role::firstOrCreate(['name' => 'driver']);
        $driverRole->syncPermissions($driverPermissions);

        // 3. Create Users and Assign Roles
        // Admin
        $adminUser = User::firstOrCreate([
            'email' => 'admin@shiplink.local',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'phone' => '01000000000',
            'address' => 'Cairo, Egypt',
            'type' => UserType::ADMIN,
            'email_verified_at' => Carbon::now(),
        ]);
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

        // Merchant
        $merchantUser = User::firstOrCreate([
            'email' => 'merchant@shiplink.local',
        ], [
            'name' => 'Demo Merchant',
            'password' => Hash::make('password'),
            'phone' => '01111111111',
            'address' => 'Giza, Egypt',
            'type' => UserType::MERCHANT,
            'email_verified_at' => Carbon::now(),
        ]);
        if (!$merchantUser->hasRole('merchant')) {
            $merchantUser->assignRole($merchantRole);
        }

        // Driver
        $driverUser = User::firstOrCreate([
            'email' => 'driver@shiplink.local',
        ], [
            'name' => 'Demo Driver',
            'password' => Hash::make('password'),
            'phone' => '01222222222',
            'address' => 'Alexandria, Egypt',
            'type' => UserType::DRIVER,
            'email_verified_at' => Carbon::now(),
        ]);
        if (!$driverUser->hasRole('driver')) {
            $driverUser->assignRole($driverRole);
        }
    }
}
