<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::where('name', 'admin')->first();
        $userManagerRole = Role::where('name', 'user_manager')->first();
        $viewerRole = Role::where('name', 'viewer')->first();

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $adminRole?->id,
            ]
        );

        // Create user manager
        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'User Manager',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $userManagerRole?->id,
            ]
        );

        // Create viewer user
        User::firstOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name' => 'Viewer User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role_id' => $viewerRole?->id,
            ]
        );
    }
}
