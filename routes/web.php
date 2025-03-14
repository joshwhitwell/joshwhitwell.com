<?php

use App\Models\ExerciseLog;
use Illuminate\Http\Request;
use App\Models\ExerciseSetLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::post('exercise-logs', function (Request $request) {
    // Auth::login(User::find(1));

    $fill = $request->validate([
        'exercise_id' => 'required|integer|exists:exercises,id',
        'user_id' => 'required|integer|exists:users,id',
        'sets' => 'required|array'
    ]);

    $exerciseLog = ExerciseLog::create([
        'exercise_id' => $fill['exercise_id'],
        'user_id' => $fill['user_id'],
    ]);

    foreach ($fill['sets'] as $setNumber => $set) {
        ExerciseSetLog::create([
            'exercise_log_id' => $exerciseLog->id,
            'set_number' => $setNumber,
            'reps' => $set['reps'],
            'weight' => $set['weight'],
            'duration' => $set['duration'],
        ]);
    }

    return redirect()->back();
})->name('exercise-logs.store');
