<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLogController;

require __DIR__ . '/auth.php';

Route::view('/', 'joshwhitwell');

Route::middleware('auth')->group(function () {
    Route::resource('exercises', ExerciseController::class);
    Route::resource('exercises.exercise-logs', ExerciseLogController::class)->only(['store']);
});
