<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Lift\MyProgramsController;

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
    });
});
