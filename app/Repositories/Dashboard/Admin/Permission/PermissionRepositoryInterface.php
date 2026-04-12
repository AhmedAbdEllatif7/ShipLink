<?php

namespace App\Repositories\Dashboard\Admin\Permission;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Permission;
}
