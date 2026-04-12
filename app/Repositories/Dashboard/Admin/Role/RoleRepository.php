<?php

namespace App\Repositories\Dashboard\Admin\Role;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function all(): Collection
    {
        return Role::with('permissions')->get();
    }

    public function store(array $data): Role
    {
        $role = Role::create(['name' => $data['name']]);
        
        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    public function update(int $id, array $data): bool
    {
        $role = Role::findOrFail($id);
        if($role->name === 'super_admin') {
            return false;
        }
        $role->update(['name' => $data['name']]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return true;
    }

    public function delete(int $id): bool
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'super_admin') {
            return false;
        }

        return $role->delete();
    }

    public function syncPermissions(int $id, array $permissions): bool
    {
        $role = Role::findOrFail($id);
        $role->syncPermissions($permissions);
        return true;
    }

    public function getAllPermissions(): Collection
    {
        return Permission::all();
    }
}
