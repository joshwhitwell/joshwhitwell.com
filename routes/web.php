<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return;
});

Route::get('/{workout}', function (string $workout) {
    $path = storage_path("app/public/$workout.json");

    if (!file_exists($path)) {
        abort(404);
    }

    $json = json_decode(file_get_contents(storage_path("app/public/$workout.json")), true);

    return view('workout', [
        'weeks' => $json
    ]);
});
