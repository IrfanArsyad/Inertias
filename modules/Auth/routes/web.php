<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Auth Module Routes
|--------------------------------------------------------------------------
|
| Authentication routes for login, logout, and guest access
|
*/

// Guest routes (only accessible when not authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Auto-login for development (optional - can be removed in production)
    Route::get('/auto-login', [LoginController::class, 'autoLogin'])->name('auto-login');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
