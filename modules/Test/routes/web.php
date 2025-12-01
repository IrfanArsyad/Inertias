<?php

use Illuminate\Support\Facades\Route;
use Modules\Test\Http\Controllers\TestController;

/*
|--------------------------------------------------------------------------
| Test Module Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your Test module.
| You can add middleware, prefix, or customize as needed per module.
|
*/

Route::middleware(['web'])->prefix('test')->name('test.')->group(function () {
    // Index - List all items
    Route::get('/', [TestController::class, 'index'])->name('index');

    // Create - Show create form
    Route::get('/create', [TestController::class, 'create'])->name('create');

    // Store - Save new item
    Route::post('/', [TestController::class, 'store'])->name('store');

    // Show - Display single item
    Route::get('/{test}', [TestController::class, 'show'])->name('show');

    // Edit - Show edit form
    Route::get('/{test}/edit', [TestController::class, 'edit'])->name('edit');

    // Update - Update existing item
    Route::put('/{test}', [TestController::class, 'update'])->name('update');
    Route::patch('/{test}', [TestController::class, 'update']);

    // Destroy - Delete single item
    Route::delete('/{test}', [TestController::class, 'destroy'])->name('destroy');

    // Bulk Destroy - Delete multiple items
    Route::delete('/bulk-destroy', [TestController::class, 'bulkDestroy'])->name('bulk-destroy');
});
