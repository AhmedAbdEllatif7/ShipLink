<?php

namespace App\Repositories\Dashboard\Admin\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface
{
    public function all(): Collection
    {
        return User::with('roles')->get();
    }

    public function find(int $id): ?User
    {
        return User::with('roles')->findOrFail($id);
    }

    public function store(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'] ?? null,
                'address' => $data['address'] ?? null,
                'type' => $data['type'] ?? 'admin',
            ]);

            if (isset($data['roles'])) {
                $user->assignRole($data['roles']);
            }

            return $user;
        });
    }

    public function update(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            $user = User::findOrFail($id);
            
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? $user->phone,
                'address' => $data['address'] ?? $user->address,
                'type' => $data['type'] ?? $user->type->value,
            ];

            if (isset($data['password']) && !empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            if ($user->hasRole('super_admin')) {
                unset($updateData['type']);
                unset($data['roles']);
            }

            $user->update($updateData);

            if (isset($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            return true;
        });
    }

    public function delete(int $id): bool
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting the main admin if necessary
        // Prevent deleting the super admin user
        if ($user->hasRole('super_admin')) {
            return false;
        }

        return $user->delete();
    }

    public function getAllRoles(): Collection
    {
        return Role::all();
    }
}
