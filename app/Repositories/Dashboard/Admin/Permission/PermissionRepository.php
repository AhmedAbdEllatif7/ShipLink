<?php

namespace App\Repositories\Dashboard\Admin\Permission;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function all(): LengthAwarePaginator
    {
        return Permission::paginate(config('shiplink.pagination_limit', 10));
    }
}
