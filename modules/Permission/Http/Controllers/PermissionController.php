<?php

declare(strict_types=1);

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Modules\Permission\Http\Requests\StorePermissionRequest;
use Modules\Permission\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    /**
     * Get permissions data from modules
     * Each module represents a permission entity with assigned roles count
     */
    private function getPermissionsData()
    {
        $modules = Module::active()->ordered()->get();
        $roles = Role::active()->get();

        return $modules->map(function ($module) use ($roles) {
            // Count users who have access to this module through any role
            $usersWithAccess = 0;
            foreach ($roles as $role) {
                if ($this->roleHasModuleAccess($role, $module->id, 'read')) {
                    $usersWithAccess += $role->users()->count();
                }
            }

            return [
                'id' => $module->id,
                'name' => $module->label ?? $module->name,
                'module_name' => $module->name,
                'icon' => $module->icon,
                'users_count' => $usersWithAccess,
                'is_core' => in_array($module->name, ['users', 'roles', 'permissions', 'settings']),
                'created_at' => $module->created_at->format('d M Y, g:i A')
            ];
        })->toArray();
    }

    /**
     * Check if role has access to a module (supports wildcard '*')
     */
    private function roleHasModuleAccess(Role $role, int $moduleId, string $action): bool
    {
        $permissions = $this->normalizePermissionArray($role->{$action});

        // Check for wildcard - has access to all modules
        if (in_array('*', $permissions)) {
            return true;
        }

        return in_array($moduleId, $permissions);
    }

    /**
     * Normalize permission array (convert object keys to array values)
     */
    private function normalizePermissionArray($permissions): array
    {
        if (empty($permissions)) {
            return [];
        }

        if (is_array($permissions) && array_keys($permissions) !== range(0, count($permissions) - 1)) {
            return array_values($permissions);
        }

        return is_array($permissions) ? $permissions : [];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Permission::permissions/Index', [
            'permissions' => $this->getPermissionsData()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Permission::permissions/Index', [
            'permissions' => $this->getPermissionsData()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $validated = $request->validated();
        $validated['order'] = Module::max('order') + 1;

        Module::create($validated);

        return redirect()->route('permission.index')
            ->with('success', 'Permission created successfully!');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $module = Module::findOrFail($id);
        $roles = Role::active()->get();

        // Get roles that have access to this module (including wildcard)
        $rolesWithAccess = $roles->filter(function ($role) use ($module) {
            return $this->roleHasModuleAccess($role, $module->id, 'read');
        });

        return Inertia::render('Permission::permissions/Show', [
            'permission' => [
                'id' => $module->id,
                'name' => $module->label ?? $module->name,
                'module_name' => $module->name,
                'icon' => $module->icon,
                'description' => 'Access to ' . ($module->label ?? $module->name) . ' module',
                'active' => $module->active,
                'roles' => $rolesWithAccess->map(fn($role) => [
                    'id' => $role->id,
                    'name' => $role->display_name ?? $role->name,
                ])->values()->toArray(),
                'created_at' => $module->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $module = Module::findOrFail($id);
        $roles = Role::active()->get();

        $usersWithAccess = 0;
        foreach ($roles as $role) {
            if ($this->roleHasModuleAccess($role, $module->id, 'read')) {
                $usersWithAccess += $role->users()->count();
            }
        }

        return Inertia::render('Permission::permissions/Index', [
            'permissions' => $this->getPermissionsData(),
            'permission' => [
                'id' => $module->id,
                'name' => $module->label ?? $module->name,
                'module_name' => $module->name,
                'icon' => $module->icon,
                'users_count' => $usersWithAccess,
                'is_core' => in_array($module->name, ['users', 'roles', 'permissions', 'settings']),
                'created_at' => $module->created_at->format('d M Y, g:i A')
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, $id)
    {
        $module = Module::findOrFail($id);

        $module->update($request->validated());

        return redirect()->route('permission.index')
            ->with('success', 'Permission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $module = Module::findOrFail($id);

        // Remove this module from all roles' permissions
        $roles = Role::all();
        foreach ($roles as $role) {
            foreach (['read', 'create', 'update', 'delete'] as $action) {
                $permissions = $this->normalizePermissionArray($role->{$action});
                $permissions = array_values(array_diff($permissions, [$module->id]));
                $role->{$action} = $permissions;
            }
            $role->save();
        }

        $module->delete();

        return redirect()->route('permission.index')
            ->with('success', 'Permission deleted successfully!');
    }

    /**
     * Bulk destroy multiple resources.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:modules,id',
        ]);

        // Remove modules from all roles' permissions
        $roles = Role::all();
        foreach ($roles as $role) {
            foreach (['read', 'create', 'update', 'delete'] as $action) {
                $permissions = $this->normalizePermissionArray($role->{$action});
                $permissions = array_values(array_diff($permissions, $validated['ids']));
                $role->{$action} = $permissions;
            }
            $role->save();
        }

        Module::whereIn('id', $validated['ids'])->delete();

        return redirect()->route('permission.index')
            ->with('success', 'Permissions deleted successfully!');
    }
}
