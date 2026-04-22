<?php

namespace App\Repositories\Dashboard\Admin\Role;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function all(): LengthAwarePaginator;


    public function store(array $data): Role;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;

    public function syncPermissions(int $id, array $permissions): bool;

    public function getAllPermissions(): Collection;
}
