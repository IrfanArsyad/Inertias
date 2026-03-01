<?php

use Illuminate\Support\Facades\Route;
use Modules\Test\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Test Module Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->prefix('test')->name('test.')->group(function () {
    // Read
    Route::middleware('permission:test,read')->group(function () {
        Route::get('/', [TestController::class, 'index'])->name('index');
        Route::get('/{test}', [TestController::class, 'show'])->name('show');
    });

    // Create
    Route::middleware('permission:test,create')->group(function () {
        Route::get('/create', [TestController::class, 'create'])->name('create');
        Route::post('/', [TestController::class, 'store'])->name('store');
    });

    // Update
    Route::middleware('permission:test,update')->group(function () {
        Route::get('/{test}/edit', [TestController::class, 'edit'])->name('edit');
        Route::put('/{test}', [TestController::class, 'update'])->name('update');
        Route::patch('/{test}', [TestController::class, 'update']);
    });

    // Delete
    Route::middleware('permission:test,delete')->group(function () {
        Route::delete('/bulk-destroy', [TestController::class, 'bulkDestroy'])->name('bulk-destroy');
        Route::delete('/{test}', [TestController::class, 'destroy'])->name('destroy');
    });
});
