<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/lift.php';

Route::get('/', function () {
    return response('', 200);
});
