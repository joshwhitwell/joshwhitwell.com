<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('joshwhitwell');
})->name('joshwhitwell');

Route::middleware('auth')->group(function () {
    Route::get('/me', function () {
        return view('me');
    })->name('me');
});

require __DIR__.'/auth.php';
