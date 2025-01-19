<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkoutProgramController;

Route::get('/', function () {
    return;
});

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
