<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Repositories\Dashboard\Admin\Role\RoleRepositoryInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view roles', only: ['index', 'show']),
            new Middleware('permission:create roles', only: ['create', 'store']),
            new Middleware('permission:edit roles', only: ['edit', 'update']),
            new Middleware('permission:delete roles', only: ['destroy']),
        ];
    }

    protected $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->all();
        return view('dashboards.admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->roleRepository->getAllPermissions();
        return view('dashboards.admin.roles.create', compact('permissions'));
    }

    public function store(RoleRequest $request)
    {
        $this->roleRepository->store($request->validated());

        return redirect()->route('admin.roles.index')->with('success', 'تم إضافة الدور بنجاح');
    }

    public function edit($id)
    {
        $role = $this->roleRepository->find($id);
        $permissions = $this->roleRepository->getAllPermissions();
        return view('dashboards.admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(RoleRequest $request, $id)
    {
        $this->roleRepository->update($id, $request->validated());

        return redirect()->route('admin.roles.index')->with('success', 'تم تعديل الدور بنجاح');
    }

    public function destroy($id)
    {
        if ($this->roleRepository->delete($id)) {
            return redirect()->route('admin.roles.index')->with('success', 'تم حذف الدور بنجاح');
        }

        return redirect()->route('admin.roles.index')->with('error', 'لا يمكن حذف هذا الدور');
    }
}
