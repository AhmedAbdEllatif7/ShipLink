<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed an admin user for the application.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@shiplink.com'],
            [
                'name' => 'Admin User',
                'phone' => '+20100000000',
                'address' => 'Cairo, Egypt',
                'type' => UserType::ADMIN,
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
            ]
        );
    }
}
