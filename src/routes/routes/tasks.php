<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('tasks')->name('tasks.')->group(function () {
    // READ
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/{id}', [TaskController::class, 'show'])->name('show');

    // CREATE
    Route::post('/', [TaskController::class, 'store'])->name('store');

    // UPDATE
    Route::patch('/{id}', [TaskController::class, 'update'])->name('update');

    // DELETE
    Route::delete('/{id}', [TaskController::class, 'delete'])->name('delete');
});
