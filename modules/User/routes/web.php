<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| User Module Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->prefix('users')->name('users.')->group(function () {
    // Read
    Route::middleware('permission:users,read')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
    });

    // Create
    Route::middleware('permission:users,create')->group(function () {
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
    });

    // Update
    Route::middleware('permission:users,update')->group(function () {
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::patch('/{user}', [UserController::class, 'update']);
        Route::patch('/{user}/toggle-verification', [UserController::class, 'toggleVerification'])
            ->name('toggle-verification');
        Route::get('/{user}/change-role', [UserController::class, 'changeRole'])
            ->name('change-role');
        Route::patch('/{user}/update-role', [UserController::class, 'updateRole'])
            ->name('update-role');
    });

    // Delete (bulk-destroy before wildcard to avoid conflict)
    Route::middleware('permission:users,delete')->group(function () {
        Route::delete('/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});
