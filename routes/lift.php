<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lift\SetLogController;
use App\Http\Controllers\Lift\MyProgramsController;
use App\Http\Controllers\Lift\MyWorkoutsController;

// Lift
Route::group([
    'as' => 'lift.',
    'prefix' => 'lift',
    'middleware' => ['auth']
], function () {
    // My
    Route::group([
        'as' => 'my.',
        'prefix' => 'my'
    ], function () {
        // Programs
        Route::resource(
            'programs',
            MyProgramsController::class
        )->only(
            ['index', 'show']
        )->parameters([
            'programs' => 'programLog'
        ]);
        
        // Workouts
        Route::resource(
            'programs.workouts',
            MyWorkoutsController::class
        )->only(
            ['edit', 'update']
        )->parameters([
            'programs' => 'programLog',
            'workouts' => 'workoutLog'
        ]);
    });

    // Set Logs
    Route::put('set-logs/{setLog}', [SetLogController::class, 'update'])->name('set-logs.update');
});
