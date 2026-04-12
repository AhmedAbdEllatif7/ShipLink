<?php

namespace App\Repositories\Dashboard\Admin\Permission;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function all(): Collection
    {
        return Permission::all();
    }

    public function find(int $id): ?Permission
    {
        return Permission::findOrFail($id);
    }
}
