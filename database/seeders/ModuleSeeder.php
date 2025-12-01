<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\ModuleGroup;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create module groups
        $groups = $this->createModuleGroups();

        // Create modules
        $this->createModules($groups);
    }

    /**
     * Create module groups
     */
    private function createModuleGroups(): array
    {
        $groupsData = [
            [
                'name' => 'Main',
                'label' => 'Main',
                'icon' => 'bx bx-home',
                'order' => 1,
                'active' => true,
            ],
            [
                'name' => 'User Management',
                'label' => 'User Management',
                'icon' => 'bx bx-user',
                'order' => 2,
                'active' => true,
            ],
            [
                'name' => 'Settings',
                'label' => 'Settings',
                'icon' => 'bx bx-cog',
                'order' => 3,
                'active' => true,
            ],
        ];

        $groups = [];
        foreach ($groupsData as $data) {
            $groups[$data['name']] = ModuleGroup::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        return $groups;
    }

    /**
     * Create modules
     */
    private function createModules(array $groups): void
    {
        $modulesData = [
            // Main
            [
                'module_groups_id' => $groups['Main']->id,
                'name' => 'dashboard',
                'label' => 'Dashboard',
                'icon' => 'bx bx-home-circle',
                'url' => '/',
                'order' => 1,
            ],

            // User Management
            [
                'module_groups_id' => $groups['User Management']->id,
                'name' => 'users',
                'label' => 'Users',
                'icon' => 'bx bx-user',
                'url' => '/users',
                'order' => 1,
            ],
            [
                'module_groups_id' => $groups['User Management']->id,
                'name' => 'role-permission',
                'label' => 'Role & Permission',
                'icon' => 'bx bx-shield',
                'url' => null,
                'order' => 2,
            ],

            // Settings
            [
                'module_groups_id' => $groups['Settings']->id,
                'name' => 'settings',
                'label' => 'General Settings',
                'icon' => 'bx bx-cog',
                'url' => '/settings',
                'order' => 1,
            ],
        ];

        $modules = [];
        foreach ($modulesData as $data) {
            $module = Module::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
            $modules[$data['name']] = $module;
        }

        // Create child modules for Role & Permission
        $rolePermissionParent = $modules['role-permission'];

        $childModulesData = [
            [
                'parent_id' => $rolePermissionParent->id,
                'module_groups_id' => $rolePermissionParent->module_groups_id,
                'name' => 'roles',
                'label' => 'Roles',
                'icon' => 'bx bx-user-check',
                'url' => '/permission/roles',
                'order' => 1,
            ],
            [
                'parent_id' => $rolePermissionParent->id,
                'module_groups_id' => $rolePermissionParent->module_groups_id,
                'name' => 'permissions',
                'label' => 'Permissions',
                'icon' => 'bx bx-lock-alt',
                'url' => '/permission',
                'order' => 2,
            ],
        ];

        foreach ($childModulesData as $data) {
            Module::firstOrCreate(
                ['name' => $data['name']],
                $data
            );
        }
    }
}
