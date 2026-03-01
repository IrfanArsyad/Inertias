<?php

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\RoleController;
use Modules\Permission\Http\Controllers\PermissionController;

/*
|--------------------------------------------------------------------------
| Permission Module Routes
|--------------------------------------------------------------------------
*/

// Roles Management Routes
Route::middleware(['web', 'auth'])->prefix('permission/roles')->name('permission.roles.')->group(function () {
    // Read
    Route::middleware('permission:roles,read')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
    });

    // Create
    Route::middleware('permission:roles,create')->group(function () {
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
    });

    // Update
    Route::middleware('permission:roles,update')->group(function () {
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::patch('/{role}', [RoleController::class, 'update']);
    });

    // Delete
    Route::middleware('permission:roles,delete')->group(function () {
        Route::delete('/bulk-destroy', [RoleController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
    });
});

// Permissions Management Routes
Route::middleware(['web', 'auth'])->prefix('permission')->name('permission.')->group(function () {
    // Read
    Route::middleware('permission:permissions,read')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
    });

    // Create
    Route::middleware('permission:permissions,create')->group(function () {
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
    });

    // Update
    Route::middleware('permission:permissions,update')->group(function () {
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
        Route::patch('/{permission}', [PermissionController::class, 'update']);
    });

    // Delete
    Route::middleware('permission:permissions,delete')->group(function () {
        Route::delete('/bulk-destroy', [PermissionController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::delete('/{permission}', [PermissionController::class, 'destroy'])->name('destroy');
    });
});
