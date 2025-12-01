<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role assigned to the user
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Check if user has wildcard permission for an action
     */
    public function hasWildcardPermission(string $action): bool
    {
        $role = $this->role;
        if (!$role || !$role->active) {
            return false;
        }
        return $role->hasWildcardPermission($action);
    }

    /**
     * Get all modules the user has access to through their role
     */
    public function getAccessibleModules()
    {
        $role = $this->role;

        // No role assigned
        if (!$role || !$role->active) {
            return collect();
        }

        // Check if user has wildcard permission (access to all modules)
        if ($role->hasWildcardPermission('read')) {
            return Module::active()
                ->with(['parent', 'children', 'moduleGroup'])
                ->ordered()
                ->get();
        }

        $moduleIds = $role->read ?? [];
        if (!is_array($moduleIds)) {
            $moduleIds = [];
        }

        return Module::whereIn('id', $moduleIds)
            ->active()
            ->with(['parent', 'children', 'moduleGroup'])
            ->ordered()
            ->get();
    }

    /**
     * Get hierarchical menu structure for user
     */
    public function getMenuStructure()
    {
        $modules = $this->getAccessibleModules();

        // Filter only parent modules and load their accessible children
        $parentModules = $modules->filter(function ($module) {
            return is_null($module->parent_id);
        });

        return $parentModules->map(function ($parent) use ($modules) {
            $parent->accessible_children = $modules->filter(function ($module) use ($parent) {
                return $module->parent_id === $parent->id;
            })->values();

            return $parent;
        })->values();
    }

    /**
     * Check if user has a specific role by name
     */
    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    /**
     * Check if user has a specific role by ID
     */
    public function hasRoleId(int $roleId): bool
    {
        return $this->role_id === $roleId;
    }

    /**
     * Check if user has any of the given roles
     */
    public function hasAnyRole(array $roleNames): bool
    {
        return $this->role && in_array($this->role->name, $roleNames);
    }

    /**
     * Check if user can perform action on module
     */
    public function canAccess(string $action, int|string $moduleId): bool
    {
        $role = $this->role;
        if (!$role || !$role->active) {
            return false;
        }

        if (is_string($moduleId)) {
            $module = Module::where('name', $moduleId)->first();
            if (!$module) {
                return false;
            }
            $moduleId = $module->id;
        }

        return $role->hasPermission($moduleId, $action);
    }

    /**
     * Check if user can read a module
     */
    public function canRead(int|string $moduleId): bool
    {
        return $this->canAccess('read', $moduleId);
    }

    /**
     * Check if user can create on a module
     */
    public function canCreate(int|string $moduleId): bool
    {
        return $this->canAccess('create', $moduleId);
    }

    /**
     * Check if user can update a module
     */
    public function canUpdate(int|string $moduleId): bool
    {
        return $this->canAccess('update', $moduleId);
    }

    /**
     * Check if user can delete on a module
     */
    public function canDelete(int|string $moduleId): bool
    {
        return $this->canAccess('delete', $moduleId);
    }

    /**
     * Get user's permissions for a specific module
     */
    public function getModulePermissions(int|string $moduleId): array
    {
        $role = $this->role;
        if (!$role || !$role->active) {
            return [
                'can_read' => false,
                'can_create' => false,
                'can_update' => false,
                'can_delete' => false,
            ];
        }

        if (is_string($moduleId)) {
            $module = Module::where('name', $moduleId)->first();
            if (!$module) {
                return [
                    'can_read' => false,
                    'can_create' => false,
                    'can_update' => false,
                    'can_delete' => false,
                ];
            }
            $moduleId = $module->id;
        }

        return $role->getModulePermissions($moduleId);
    }

    /**
     * Get all permissions for all modules user has access to
     */
    public function getAllModulePermissions(): array
    {
        $modules = $this->getAccessibleModules();
        $allPermissions = [];

        foreach ($modules as $module) {
            $allPermissions[$module->id] = $this->getModulePermissions($module->id);
        }

        return $allPermissions;
    }

    /**
     * Assign a role to the user
     */
    public function assignRole(int|string $role): void
    {
        if (is_string($role)) {
            $roleModel = Role::where('name', $role)->first();
            if (!$roleModel) {
                return;
            }
            $this->role_id = $roleModel->id;
        } elseif (is_object($role)) {
            $this->role_id = $role->id;
        } else {
            $this->role_id = $role;
        }

        $this->save();
    }

    /**
     * Remove role from the user
     */
    public function removeRole(): void
    {
        $this->role_id = null;
        $this->save();
    }
}
