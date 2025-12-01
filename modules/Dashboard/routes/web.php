<?php

use Illuminate\Support\Facades\Route;
use Modules\Dashboard\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your module. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
    // Resource routes for CRUD operations
    Route::resource('dashboard', DashboardController::class);
    
    // Bulk delete route
    Route::delete('dashboard/bulk-destroy', [DashboardController::class, 'bulkDestroy'])
        ->name('dashboard.bulk-destroy');
    
    // Additional custom routes
    // Route::get('custom-route', [DashboardController::class, 'customMethod'])->name('dashboard.custom');
});
