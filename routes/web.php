<?php

use App\Models\Writing;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('joshwhitwell');
})->name('joshwhitwell');

Route::middleware('auth')->group(function () {
    Route::get('/me', function () {
        return view('me');
    })->name('me');

    Route::post('/writings', function () {
        $data = request()->validate([
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'body' => ['required', 'string'],
            'written_at' => ['sometimes', 'nullable', 'date'],
        ]);

        Writing::create($data);

        return redirect()->route('me');
    })->name('writings.store');
});

require __DIR__.'/auth.php';
