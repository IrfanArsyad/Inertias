<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\RoleController;
use Modules\Permission\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Permission Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your Permission module.
| You can add middleware, prefix, or customize as needed per module.
|
*/

// Roles Management Routes - MUST be before Permission routes to avoid conflict
Route::middleware(['web'])->prefix('permission/roles')->name('permission.roles.')->group(function () {
    // Index - List all roles
    Route::get('/', [RoleController::class, 'index'])->name('index');

    // Create - Show create form
    Route::get('/create', [RoleController::class, 'create'])->name('create');

    // Store - Save new role
    Route::post('/', [RoleController::class, 'store'])->name('store');

    // Show - Display single role
    Route::get('/{role}', [RoleController::class, 'show'])->name('show');

    // Edit - Show edit form
    Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');

    // Update - Update existing role
    Route::put('/{role}', [RoleController::class, 'update'])->name('update');
    Route::patch('/{role}', [RoleController::class, 'update']);

    // Destroy - Delete single role
    Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');

    // Bulk Destroy - Delete multiple roles
    Route::delete('/bulk-destroy', [RoleController::class, 'bulkDestroy'])->name('bulk-destroy');
});

// Permissions Management Routes
Route::middleware(['web'])->prefix('permission')->name('permission.')->group(function () {
    // Index - List all permissions
    Route::get('/', [PermissionController::class, 'index'])->name('index');

    // Create - Show create form
    Route::get('/create', [PermissionController::class, 'create'])->name('create');

    // Store - Save new permission
    Route::post('/', [PermissionController::class, 'store'])->name('store');

    // Show - Display single permission
    Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');

    // Edit - Show edit form
    Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');

    // Update - Update existing permission
    Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
    Route::patch('/{permission}', [PermissionController::class, 'update']);

    // Destroy - Delete single permission
    Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');

    // Bulk Destroy - Delete multiple permissions
    Route::delete('/bulk-destroy', [PermissionController::class, 'bulkDestroy'])->name('bulk-destroy');
});
