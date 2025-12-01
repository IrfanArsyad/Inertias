<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ModuleSeeder::class, // Creates module_groups and modules
            RoleSeeder::class,   // Creates roles with permissions
            UserSeeder::class,   // Creates users with role_id
        ]);
    }
}
