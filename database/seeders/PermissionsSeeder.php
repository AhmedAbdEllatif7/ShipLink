<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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

        // Create Permissions
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create Roles and Assign Explicit Permissions
        $adminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole->syncPermissions($allPermissions);

        $merchantRole = Role::firstOrCreate(['name' => 'merchant']);
        $merchantRole->syncPermissions($merchantPermissions);

        $driverRole = Role::firstOrCreate(['name' => 'driver']);
        $driverRole->syncPermissions($driverPermissions);
    }
}
