<?php

use Illuminate\Support\Facades\Route;

$groupParams = [
    'middleware' => 'auth',
    'prefix' => 'lift',
    'name' => 'lift.',
];

Route::group($groupParams, function () {
    Route::view('/', 'lift.lift')->name('lift');
});
