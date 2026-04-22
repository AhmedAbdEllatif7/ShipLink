<?php

namespace App\Repositories\Dashboard\Admin\Permission;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Permission;

interface PermissionRepositoryInterface
{
    public function all(): LengthAwarePaginator;
}
