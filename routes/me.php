<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/me', function () {
        return Inertia::render('Me/Index');
    })->name('me');

    Route::prefix('my')->name('my.')->group(function () {
        Route::resource('notes', NoteController::class)->only(['store']);

        Route::get('type', function () {
            return Inertia::render('My/Type');
        })->name('type');
    });
});
