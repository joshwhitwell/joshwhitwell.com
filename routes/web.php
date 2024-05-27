<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\My\WritingController;

Route::get('/', function () {
    return view('joshwhitwell');
})->name('joshwhitwell');

Route::middleware('auth')->group(function () {
    Route::get('/me', function () {
        return view('me');
    })->name('me');

    Route::prefix('my')->name('my.')->group(function () {
        Route::resource('writings', WritingController::class);
    });
});

require __DIR__.'/auth.php';
