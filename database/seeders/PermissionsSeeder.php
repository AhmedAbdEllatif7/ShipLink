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

        // 1. Define distinct granular permissions
        $adminPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
        ];

        $merchantPermissions = [
            'create shipments',
            'view own shipments',
            'create shipments',    
            'view own shipments',   
        ];

        $driverPermissions = [
            'view assigned shipments',
            'update shipment status',
            'view assigned shipments', 
            'update shipment status',  
        ];

        $allAdminPermissions = array_merge(
            $adminPermissions,
            $merchantPermissions,
            $driverPermissions
        );



        // Create all permissions in one go
        $allPermissions = array_unique(array_merge(
            $allAdminPermissions,
            $merchantPermissions,
            $driverPermissions,
        ));

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Create Roles and Assign Explicit Permissions
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdminRole->syncPermissions(Permission::all());

        // We can also create a regular admin role to test granular permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($allAdminPermissions);

        $merchantRole = Role::firstOrCreate(['name' => 'merchant']);
        $merchantRole->syncPermissions($merchantPermissions);

        $driverRole = Role::firstOrCreate(['name' => 'driver']);
        $driverRole->syncPermissions($driverPermissions);
    }
}
