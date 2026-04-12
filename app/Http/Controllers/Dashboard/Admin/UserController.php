<?php

namespace App\Http\Controllers\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Repositories\Dashboard\Admin\User\UserRepositoryInterface;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view users', only: ['index', 'show']),
            new Middleware('permission:create users', only: ['create', 'store']),
            new Middleware('permission:edit users', only: ['edit', 'update']),
            new Middleware('permission:delete users', only: ['destroy']),
        ];
    }

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->all();
        return view('dashboards.admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->userRepository->getAllRoles();
        return view('dashboards.admin.users.create', compact('roles'));
    }

    public function store(UserRequest $request)
    {
        $this->userRepository->store($request->validated());

        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit($id)
    {
        $user = $this->userRepository->find($id);
        $roles = $this->userRepository->getAllRoles();
        return view('dashboards.admin.users.edit', compact('user', 'roles'));
    }

    public function update(UserRequest $request, $id)
    {
        $this->userRepository->update($id, $request->validated());

        return redirect()->route('admin.users.index')->with('success', 'تم تعديل المستخدم بنجاح');
    }

    public function destroy($id)
    {
        if ($this->userRepository->delete($id)) {
            return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح');
        }

        return redirect()->route('admin.users.index')->with('error', 'لا يمكن حذف هذا المستخدم');
    }
}
