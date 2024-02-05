<?php

use App\Models\Note;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/me', function () {
        return Inertia::render('Me/Index', [
            'notes' => Note::orderBy('created_at', 'desc')
                ->select(['id', 'body', 'created_at'])
                ->limit(3)
                ->get()
                ->map(function ($note) {
                    $createdAt = $note->created_at;
                    $createdAt->setTimezone('America/New_York');
                    return [
                        'id' => $note->id,
                        'body' => $note->body,
                        'created_at' => $createdAt->format('M d, Y'),
                    ];
                }),
        ]);
    })->name('me');

    Route::prefix('my')->name('my.')->group(function () {
        Route::resource('notes', NoteController::class);

        Route::get('type', function () {
            return Inertia::render('My/Type');
        })->name('type');
    });
});
