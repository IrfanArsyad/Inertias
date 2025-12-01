<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class ModuleGroup extends Model
{

    protected $fillable = [
        'name',
        'label',
        'icon',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Get the modules in this group
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'module_groups_id')
            ->orderBy('order');
    }

    /**
     * Get only active modules in this group
     */
    public function activeModules(): HasMany
    {
        return $this->modules()->where('active', true);
    }

    /**
     * Scope to get only active module groups
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope to order module groups by the order column
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('order');
    }
}
