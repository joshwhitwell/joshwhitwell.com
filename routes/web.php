<?php

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $string = Inspiring::quote();
    $quote = Str::between($string, '<options=bold>“ ', ' ”</>');
    $attribution = Str::between($string, '<fg=gray>— ', '</>');

    return Inertia::render('JoshWhitwell/Index', [
        'quote' => $quote,
        'attribution' => $attribution,
        'bodyClass' => ''
    ]);
});

require __DIR__.'/auth.php';
require __DIR__.'/me.php';
