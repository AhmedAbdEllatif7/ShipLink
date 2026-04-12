<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Merchant;
use App\Models\Driver;
use App\Enums\UserType;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define demo users
        $users = [
            [
                'email' => 'admin@shiplink.local',
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '01000000000',
                'address' => 'Cairo, Egypt',
                'type' => UserType::ADMIN,
                'role' => 'super_admin',
            ],
            [
                'email' => 'merchant@shiplink.local',
                'name' => 'Demo Merchant',
                'password' => Hash::make('password'),
                'phone' => '01111111111',
                'address' => 'Giza, Egypt',
                'type' => UserType::MERCHANT,
                'role' => 'merchant',
            ],
            [
                'email' => 'driver@shiplink.local',
                'name' => 'Demo Driver',
                'password' => Hash::make('password'),
                'phone' => '01222222222',
                'address' => 'Alexandria, Egypt',
                'type' => UserType::DRIVER,
                'role' => 'driver',
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role'];
            unset($userData['role']); // Remove role from array before create

            $user = User::firstOrCreate(['email' => $userData['email']], array_merge($userData, ['email_verified_at' => Carbon::now()]));

            // Assign role if it exists and user doesn't have it
            if (Role::where('name', $roleName)->exists() && !$user->hasRole($roleName)) {
                $user->assignRole($roleName);
            }

            // Create Profile Record if not exists
            if ($user->type === UserType::MERCHANT) {
                Merchant::firstOrCreate(
                    ['user_id' => $user->id],
                    ['company_name' => $user->name . ' Co.']
                );
            } elseif ($user->type === UserType::DRIVER) {
                Driver::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'vehicle_type' => 'motorcycle',
                        'is_available' => true
                    ]
                );
            }
        }
    }
}
