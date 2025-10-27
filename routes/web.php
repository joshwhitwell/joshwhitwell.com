<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::view('/', 'welcome')->name('welcome');

Route::middleware(['auth'])->group(function () {
    Route::view('me', 'me')->name('me');
});
