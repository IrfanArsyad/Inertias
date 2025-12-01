<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| User Module Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->prefix('users')->name('users.')->group(function () {
    // Index - List all users
    Route::get('/', [UserController::class, 'index'])->name('index');

    // Create - Show create form
    Route::get('/create', [UserController::class, 'create'])->name('create');

    // Store - Save new user
    Route::post('/', [UserController::class, 'store'])->name('store');

    // Bulk delete (must be before show route to avoid conflict)
    Route::delete('/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('bulk-destroy');

    // Show - Display single user
    Route::get('/{user}', [UserController::class, 'show'])->name('show');

    // Edit - Show edit form
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');

    // Update - Update existing user
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::patch('/{user}', [UserController::class, 'update']);

    // Destroy - Delete single user
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');

    // Toggle verification
    Route::patch('/{user}/toggle-verification', [UserController::class, 'toggleVerification'])
        ->name('toggle-verification');

    // Change role (modal)
    Route::get('/{user}/change-role', [UserController::class, 'changeRole'])
        ->name('change-role');

    // Update role
    Route::patch('/{user}/update-role', [UserController::class, 'updateRole'])
        ->name('update-role');
});
