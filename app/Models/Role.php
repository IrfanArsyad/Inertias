<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'active',
        'read',
        'create',
        'update',
        'delete',
    ];

    protected $casts = [
        'active' => 'boolean',
        'read' => 'array',
        'create' => 'array',
        'update' => 'array',
        'delete' => 'array',
    ];

    /**
     * Get the users that have this role
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Check if permission array has wildcard access (all modules)
     */
    public function hasWildcardPermission(string $action): bool
    {
        $permissionArray = $this->{$action} ?? [];
        return in_array('*', $permissionArray);
    }

    /**
     * Check if role has permission for a specific module and action
     */
    public function hasPermission(int|string $moduleId, string $action): bool
    {
        $permissionArray = $this->{$action} ?? [];

        // Check for wildcard - has access to all modules
        if (in_array('*', $permissionArray)) {
            return true;
        }

        // Convert module slug to ID if needed
        if (is_string($moduleId)) {
            $module = Module::where('name', $moduleId)->first();
            if (!$module) {
                return false;
            }
            $moduleId = $module->id;
        }

        return in_array($moduleId, $permissionArray);
    }

    /**
     * Grant permission to a module for specific action
     */
    public function grantPermission(int|string $moduleId, string $action): self
    {
        if (is_string($moduleId)) {
            $module = Module::where('name', $moduleId)->first();
            if (!$module) {
                return $this;
            }
            $moduleId = $module->id;
        }

        $permissions = $this->{$action} ?? [];

        if (!in_array($moduleId, $permissions)) {
            $permissions[] = $moduleId;
            $this->{$action} = $permissions;
            $this->save();
        }

        return $this;
    }

    /**
     * Revoke permission from a module for specific action
     */
    public function revokePermission(int|string $moduleId, string $action): self
    {
        if (is_string($moduleId)) {
            $module = Module::where('name', $moduleId)->first();
            if (!$module) {
                return $this;
            }
            $moduleId = $module->id;
        }

        $permissions = $this->{$action} ?? [];
        $permissions = array_values(array_diff($permissions, [$moduleId]));
        $this->{$action} = $permissions;
        $this->save();

        return $this;
    }

    /**
     * Grant all permissions (CRUD) to a module
     */
    public function grantAllPermissions(int|string $moduleId): self
    {
        $this->grantPermission($moduleId, 'read');
        $this->grantPermission($moduleId, 'create');
        $this->grantPermission($moduleId, 'update');
        $this->grantPermission($moduleId, 'delete');

        return $this;
    }

    /**
     * Revoke all permissions (CRUD) from a module
     */
    public function revokeAllPermissions(int|string $moduleId): self
    {
        $this->revokePermission($moduleId, 'read');
        $this->revokePermission($moduleId, 'create');
        $this->revokePermission($moduleId, 'update');
        $this->revokePermission($moduleId, 'delete');

        return $this;
    }

    /**
     * Sync permissions for a specific action
     */
    public function syncPermissions(array $moduleIds, string $action): self
    {
        $this->{$action} = $moduleIds;
        $this->save();

        return $this;
    }

    /**
     * Get all readable modules
     */
    public function getReadableModules()
    {
        if ($this->hasWildcardPermission('read')) {
            return Module::active()->ordered()->get();
        }

        $moduleIds = $this->read ?? [];
        return Module::whereIn('id', $moduleIds)->active()->ordered()->get();
    }

    /**
     * Get all creatable modules
     */
    public function getCreatableModules()
    {
        if ($this->hasWildcardPermission('create')) {
            return Module::active()->ordered()->get();
        }

        $moduleIds = $this->create ?? [];
        return Module::whereIn('id', $moduleIds)->active()->ordered()->get();
    }

    /**
     * Get all updatable modules
     */
    public function getUpdatableModules()
    {
        if ($this->hasWildcardPermission('update')) {
            return Module::active()->ordered()->get();
        }

        $moduleIds = $this->update ?? [];
        return Module::whereIn('id', $moduleIds)->active()->ordered()->get();
    }

    /**
     * Get all deletable modules
     */
    public function getDeletableModules()
    {
        if ($this->hasWildcardPermission('delete')) {
            return Module::active()->ordered()->get();
        }

        $moduleIds = $this->delete ?? [];
        return Module::whereIn('id', $moduleIds)->active()->ordered()->get();
    }

    /**
     * Get permissions summary for a specific module
     */
    public function getModulePermissions(int|string $moduleId): array
    {
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

        return [
            'can_read' => $this->hasPermission($moduleId, 'read'),
            'can_create' => $this->hasPermission($moduleId, 'create'),
            'can_update' => $this->hasPermission($moduleId, 'update'),
            'can_delete' => $this->hasPermission($moduleId, 'delete'),
        ];
    }

    /**
     * Scope to get only active roles
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }
}
