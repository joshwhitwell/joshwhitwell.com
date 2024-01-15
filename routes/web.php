<?php

// use App\Http\Controllers\ProfileController;
// use Illuminate\Foundation\Application;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $string = Illuminate\Foundation\Inspiring::quote();
    $quote = Illuminate\Support\Str::between($string, '<options=bold>“ ', ' ”</>');
    $attribution = Illuminate\Support\Str::between($string, '<fg=gray>— ', '</>');

    return Inertia::render('JoshWhitwell/Index', [
        'quote' => $quote,
        'attribution' => $attribution,
    ]);
});

Route::get('/me', function () {
    return Inertia::render('Me');
})->middleware(['auth', 'verified'])->name('me');

Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
