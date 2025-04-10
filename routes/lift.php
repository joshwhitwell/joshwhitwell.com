<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lift\MyProgramsController;
use App\Http\Controllers\Lift\MyWorkoutsController;

Route::group([
    'as' => 'lift.',
    'prefix' => 'lift',
    'middleware' => ['auth']
], function () {
    Route::group([
        'as' => 'my.',
        'prefix' => 'my'
    ], function () {
        Route::resource(
            'programs',
            MyProgramsController::class
        )->only(
            ['index', 'show']
        )->parameters([
            'programs' => 'programLog'
        ]);

        Route::resource(
            'programs.workouts',
            MyWorkoutsController::class
        )->only(
            ['edit']
        )->parameters([
            'programs' => 'programLog',
            'workouts' => 'workoutLog'
        ]);
    });
});
