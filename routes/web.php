<?php

use function view;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
