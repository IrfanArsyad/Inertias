<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'parent_id',
        'module_groups_id',
        'permission',
        'name',
        'alias',
        'label',
        'icon',
        'url',
        'route_name',
        'badge_source',
        'active',
        'external',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'external' => 'boolean',
        'order' => 'integer',
        'parent_id' => 'integer',
        'module_groups_id' => 'integer',
    ];

    /**
     * Get the parent module (for hierarchical structure)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Module::class, 'parent_id');
    }

    /**
     * Get the child modules
     */
    public function children(): HasMany
    {
        return $this->hasMany(Module::class, 'parent_id')
            ->orderBy('order');
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    /**
     * Get the module group
     */
    public function moduleGroup(): BelongsTo
    {
        return $this->belongsTo(ModuleGroup::class, 'module_groups_id');
    }

    /**
     * Get all roles that have read access to this module
     */
    public function getRolesWithAccess()
    {
        return Role::active()
            ->get()
            ->filter(function ($role) {
                $readPermissions = $role->read ?? [];
                return in_array($this->id, $readPermissions);
            });
    }

    /**
     * Get all roles that can create on this module
     */
    public function getRolesWithCreateAccess()
    {
        return Role::active()
            ->get()
            ->filter(function ($role) {
                $createPermissions = $role->create ?? [];
                return in_array($this->id, $createPermissions);
            });
    }

    /**
     * Get all roles that can update this module
     */
    public function getRolesWithUpdateAccess()
    {
        return Role::active()
            ->get()
            ->filter(function ($role) {
                $updatePermissions = $role->update ?? [];
                return in_array($this->id, $updatePermissions);
            });
    }

    /**
     * Get all roles that can delete on this module
     */
    public function getRolesWithDeleteAccess()
    {
        return Role::active()
            ->get()
            ->filter(function ($role) {
                $deletePermissions = $role->delete ?? [];
                return in_array($this->id, $deletePermissions);
            });
    }

    /**
     * Scope to get only active modules
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope to get only external modules
     */
    public function scopeExternal(Builder $query): Builder
    {
        return $query->where('external', true);
    }

    /**
     * Scope to get only internal modules
     */
    public function scopeInternal(Builder $query): Builder
    {
        return $query->where('external', false);
    }

    /**
     * Scope to order modules by the order column
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }

    /**
     * Scope to get only parent modules (no parent_id)
     */
    public function scopeParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get modules by group
     */
    public function scopeByGroup(Builder $query, int $groupId): Builder
    {
        return $query->where('module_groups_id', $groupId);
    }

    /**
     * Check if module is a parent
     */
    public function isParent(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if module is a child
     */
    public function isChild(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Get breadcrumb trail
     */
    public function getBreadcrumb(): array
    {
        $breadcrumb = [$this];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($breadcrumb, $parent);
            $parent = $parent->parent;
        }

        return $breadcrumb;
    }
}
