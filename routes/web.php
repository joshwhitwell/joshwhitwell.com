<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\ExerciseLogController;
use App\Http\Controllers\TranslationController;

require __DIR__ . '/auth.php';

Route::view('/', 'joshwhitwell');

Route::middleware('auth')->group(function () {
    Route::get('me', [MeController::class, 'me'])->name('me');

    Route::resource('notes', NoteController::class)->only(['store']);

    Route::resource('translations', TranslationController::class)->except(['show']);

    Route::resource('exercises', ExerciseController::class);
    Route::resource('exercises.exercise-logs', ExerciseLogController::class)->only(['store']);
});
