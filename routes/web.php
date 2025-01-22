<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\DenyAsNotFound;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WorkoutProgramController;

Route::get('/', function () {
    if (auth()->check()) {
        return 'Logged in';
    }

    return '';
});

Route::get('login', [LoginController::class, 'login'])->name('login');

Route::post('login', [LoginController::class, 'authenticate']);

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware([DenyAsNotFound::class])->group(function () {
    Route::get(
        'workout-programs/{program}',
        [WorkoutProgramController::class, 'show']
    )->name('workout-programs.show');

    Route::get(
        'workout-programs/{program}/weeks/{week}',
        [WorkoutProgramController::class, 'showWeek']
    )->name('workout-programs.weeks.show');

    Route::get(
        'workout-programs/{program}/weeks/{week}/workouts/{workout}',
        [WorkoutProgramController::class, 'showWorkout']
    )->name('workout-programs.weeks.workouts.show');
});
