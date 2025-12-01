<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Module;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get modules for permission assignment
        $modules = Module::all()->keyBy('name');

        // Admin role - full access using wildcard
        Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Full access to all modules and features',
                'active' => true,
                'read' => ['*'],
                'create' => ['*'],
                'update' => ['*'],
                'delete' => ['*'],
            ]
        );

        // User Manager role - manage users, roles, and permissions
        $dashboardModule = $this->getModuleIds($modules, ['dashboard']);
        $userManagerModules = $this->getModuleIds($modules, ['dashboard', 'users', 'roles', 'permissions']);
        Role::firstOrCreate(
            ['name' => 'user_manager'],
            [
                'display_name' => 'User Manager',
                'description' => 'Can manage users, roles, and permissions',
                'active' => true,
                'read' => $userManagerModules,
                'create' => $this->getModuleIds($modules, ['users']),
                'update' => $this->getModuleIds($modules, ['users', 'roles']),
                'delete' => $this->getModuleIds($modules, ['users']),
            ]
        );

        // Viewer role - read-only access to dashboard
        Role::firstOrCreate(
            ['name' => 'viewer'],
            [
                'display_name' => 'Viewer',
                'description' => 'Read-only access to dashboard',
                'active' => true,
                'read' => $dashboardModule,
                'create' => [],
                'update' => [],
                'delete' => [],
            ]
        );
    }

    /**
     * Get module IDs by names
     */
    private function getModuleIds($modules, array $names): array
    {
        $ids = [];
        foreach ($names as $name) {
            if (isset($modules[$name])) {
                $ids[] = $modules[$name]->id;
            }
        }
        return $ids;
    }
}
