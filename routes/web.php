<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get(
    '/',
    function () {
        return Inertia::render('Welcome');
    }
)->name('home');

Route::get(
    'dashboard',
    function () {
        return Inertia::render('Dashboard');
    }
)->middleware(['auth', 'verified'])->name('dashboard');

// PWA offline fallback route
Route::get(
    '/offline.html',
    function () {
        return file_get_contents(public_path('offline.html'));
    }
);

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
