<?php

namespace Modules\Permission\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Module;
use Emargareten\InertiaModal\Modal;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Get roles from database
     */
    private function getRolesData()
    {
        return Role::withCount('users')
            ->orderBy('name')
            ->get()
            ->map(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'display_name' => $role->display_name ?? ucfirst($role->name),
                    'description' => $role->description,
                    'active' => $role->active,
                    'users_count' => $role->users_count,
                    'read' => $this->normalizePermissionArray($role->read),
                    'create' => $this->normalizePermissionArray($role->create),
                    'update' => $this->normalizePermissionArray($role->update),
                    'delete' => $this->normalizePermissionArray($role->delete),
                    'created_at' => $role->created_at->format('Y-m-d H:i:s')
                ];
            })
            ->toArray();
    }

    /**
     * Normalize permission array (convert object keys to array values)
     */
    private function normalizePermissionArray($permissions): array
    {
        if (empty($permissions)) {
            return [];
        }

        // If it's an associative array (object), get only the values
        if (is_array($permissions) && array_keys($permissions) !== range(0, count($permissions) - 1)) {
            return array_values($permissions);
        }

        return is_array($permissions) ? $permissions : [];
    }

    /**
     * Get modules from database
     */
    private function getModulesData()
    {
        return Module::active()
            ->ordered()
            ->get(['id', 'name', 'label', 'icon'])
            ->toArray();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Permission::roles/Index', [
            'roles' => $this->getRolesData(),
            'modules' => $this->getModulesData()
        ]);
    }

    /**
     * Show the form for creating a new resource (modal).
     */
    public function create(): Modal
    {
        return Inertia::modal('Permission::roles/create', [
            'modules' => $this->getModulesData()
        ])->baseRoute('permission.roles.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'read' => 'nullable|array',
            'create' => 'nullable|array',
            'update' => 'nullable|array',
            'delete' => 'nullable|array',
        ]);

        Role::create($validated);

        return redirect()->route('permission.roles.index')
            ->with('success', 'Role created successfully!');
    }

    /**
     * Show the specified resource (modal).
     */
    public function show($id): Modal
    {
        $role = Role::withCount('users')->findOrFail($id);

        return Inertia::modal('Permission::roles/show', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name ?? ucfirst($role->name),
                'description' => $role->description,
                'active' => $role->active,
                'users_count' => $role->users_count,
                'read' => $this->normalizePermissionArray($role->read),
                'create' => $this->normalizePermissionArray($role->create),
                'update' => $this->normalizePermissionArray($role->update),
                'delete' => $this->normalizePermissionArray($role->delete),
                'created_at' => $role->created_at->format('Y-m-d H:i:s')
            ],
            'modules' => $this->getModulesData()
        ])->baseRoute('permission.roles.index');
    }

    /**
     * Show the form for editing the specified resource (modal).
     */
    public function edit($id): Modal
    {
        $role = Role::withCount('users')->findOrFail($id);

        // Prevent editing Administrator role
        if (strtolower($role->name) === 'administrator') {
            return redirect()->route('permission.roles.index')
                ->with('error', 'Administrator role cannot be edited.');
        }

        return Inertia::modal('Permission::roles/edit', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'display_name' => $role->display_name ?? ucfirst($role->name),
                'description' => $role->description,
                'active' => $role->active,
                'users_count' => $role->users_count,
                'read' => $this->normalizePermissionArray($role->read),
                'create' => $this->normalizePermissionArray($role->create),
                'update' => $this->normalizePermissionArray($role->update),
                'delete' => $this->normalizePermissionArray($role->delete),
                'created_at' => $role->created_at->format('Y-m-d H:i:s')
            ],
            'modules' => $this->getModulesData()
        ])->baseRoute('permission.roles.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        // Prevent updating Administrator role
        if (strtolower($role->name) === 'administrator') {
            return redirect()->route('permission.roles.index')
                ->with('error', 'Administrator role cannot be modified.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'active' => 'boolean',
            'read' => 'nullable|array',
            'create' => 'nullable|array',
            'update' => 'nullable|array',
            'delete' => 'nullable|array',
        ]);

        $role->update($validated);

        return redirect()->route('permission.roles.index')
            ->with('success', 'Role updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // Prevent deleting Administrator role
        if (strtolower($role->name) === 'administrator') {
            return redirect()->route('permission.roles.index')
                ->with('error', 'Administrator role cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('permission.roles.index')
            ->with('success', 'Role deleted successfully!');
    }

    /**
     * Bulk destroy multiple resources.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:roles,id',
        ]);

        // Filter out Administrator role from deletion
        $adminRole = Role::whereRaw('LOWER(name) = ?', ['administrator'])->first();
        $ids = array_filter($validated['ids'], fn($id) => $adminRole ? $id !== $adminRole->id : true);

        if (empty($ids)) {
            return redirect()->route('permission.roles.index')
                ->with('error', 'Administrator role cannot be deleted.');
        }

        Role::whereIn('id', $ids)->delete();

        return redirect()->route('permission.roles.index')
            ->with('success', count($ids) . ' role(s) deleted successfully!');
    }
}
