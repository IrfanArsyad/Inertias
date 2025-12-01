<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Module;
use App\Models\ModuleGroup;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $user = $request->user();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $user,
                'role' => $user?->role ? [
                    'id' => $user->role->id,
                    'name' => $user->role->name,
                    'display_name' => $user->role->display_name,
                ] : null,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
                'warning' => fn () => $request->session()->get('warning'),
                'info' => fn () => $request->session()->get('info'),
            ],
            // Get menu items filtered by user permissions
            'menuItems' => fn () => $this->getMenuItems($user),
            // Share user permissions for current page's module
            'permissions' => fn () => $this->getCurrentModulePermissions($request, $user),
        ]);
    }

    /**
     * Get menu items from modules grouped by module_groups
     * Filtered by user's permissions
     */
    protected function getMenuItems($user): array
    {
        $menuItems = [];

        // If no user, return empty menu
        if (!$user) {
            return $menuItems;
        }

        // Get accessible module IDs for this user
        $accessibleModuleIds = $this->getAccessibleModuleIds($user);

        // Get all active module groups ordered
        $groups = ModuleGroup::active()->ordered()->get();

        foreach ($groups as $group) {
            // Get parent modules for this group that user has access to
            $modules = Module::active()
                ->parents()
                ->byGroup($group->id)
                ->ordered()
                ->with(['children' => function ($query) {
                    $query->active()->ordered();
                }])
                ->get()
                ->filter(function ($module) use ($accessibleModuleIds, $user) {
                    // Check if parent module is accessible
                    // or if any of its children are accessible
                    if (in_array($module->id, $accessibleModuleIds)) {
                        return true;
                    }

                    // Check children
                    foreach ($module->children as $child) {
                        if (in_array($child->id, $accessibleModuleIds)) {
                            return true;
                        }
                    }

                    return false;
                });

            // Skip group if no modules
            if ($modules->isEmpty()) {
                continue;
            }

            // Add group header
            $menuItems[] = [
                'type' => 'header',
                'label' => $group->label ?? $group->name
            ];

            foreach ($modules as $module) {
                $item = [
                    'id' => $module->id,
                    'name' => $module->name,
                    'label' => $module->label,
                    'icon' => $module->icon ?? 'bx bx-circle',
                    'permissions' => $user->getModulePermissions($module->id),
                ];

                // If module has URL/route, add it
                if ($module->url) {
                    $item['route'] = $module->url;
                }

                // If module has children, filter and add them
                if ($module->children->isNotEmpty()) {
                    $accessibleChildren = $module->children
                        ->filter(fn ($child) => in_array($child->id, $accessibleModuleIds))
                        ->map(function ($child) use ($user) {
                            return [
                                'id' => $child->id,
                                'name' => $child->name,
                                'label' => $child->label,
                                'route' => $child->url,
                                'permissions' => $user->getModulePermissions($child->id),
                            ];
                        })
                        ->values()
                        ->toArray();

                    if (!empty($accessibleChildren)) {
                        $item['children'] = $accessibleChildren;
                    }
                }

                $menuItems[] = $item;
            }
        }

        return $menuItems;
    }

    /**
     * Get accessible module IDs for user
     */
    protected function getAccessibleModuleIds($user): array
    {
        $role = $user->role;

        // No role assigned
        if (!$role || !$role->active) {
            return [];
        }

        // Check for wildcard permission
        if ($role->hasWildcardPermission('read')) {
            return Module::active()->pluck('id')->toArray();
        }

        $moduleIds = $role->read ?? [];
        return is_array($moduleIds) ? $moduleIds : [];
    }

    /**
     * Get permissions for current module based on route
     */
    protected function getCurrentModulePermissions(Request $request, $user): array
    {
        if (!$user) {
            return [
                'can_read' => false,
                'can_create' => false,
                'can_update' => false,
                'can_delete' => false,
            ];
        }

        // Try to determine module from route
        $routeName = $request->route()?->getName();
        $path = $request->path();

        // Extract module name from route or path
        $moduleName = $this->extractModuleName($routeName, $path);

        if ($moduleName) {
            return $user->getModulePermissions($moduleName);
        }

        // Default permissions if module not found
        return [
            'can_read' => true,
            'can_create' => false,
            'can_update' => false,
            'can_delete' => false,
        ];
    }

    /**
     * Extract module name from route name or path
     */
    protected function extractModuleName(?string $routeName, string $path): ?string
    {
        // Try from route name first (e.g., "permission.roles.index" -> "roles")
        if ($routeName) {
            $parts = explode('.', $routeName);
            // Get the second part if exists, otherwise first
            if (count($parts) >= 2) {
                return $parts[1];
            }
            return $parts[0];
        }

        // Try from path (e.g., "/permission/roles" -> "roles")
        $segments = array_filter(explode('/', $path));
        if (!empty($segments)) {
            // Return the last meaningful segment
            return end($segments);
        }

        return null;
    }
}
