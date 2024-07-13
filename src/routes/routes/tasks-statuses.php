<?php

use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::prefix('tasks-statuses')->name('tasksStatuses.')->group(function () {
    // READ
    Route::get('/', [TaskStatusController::class, 'index'])->name('index');
    Route::get('/{id}', [TaskStatusController::class, 'show'])->name('show');
});
