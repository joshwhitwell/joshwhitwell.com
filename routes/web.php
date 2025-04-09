<?php

use Illuminate\Http\Request;
use App\Models\Lift\ProgramLog;
use App\Models\Lift\WorkoutLog;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->intended('lift.my.programs');
});

Route::get('/my/programs/{programLog}/days/{programDayLog}', function (ProgramLog $programLog, WorkoutLog $programDayLog) {
    $programDayLog->load([
        'workoutExerciseLogs',
        'workoutExerciseLogs.workoutExercise',
        'workoutExerciseLogs.workoutExercise.exercise',
        'workoutExerciseLogs.setLogs',
        'workoutExerciseLogs.setLogs.set'
    ]);

    return view('program-day', [
        'programDayLog' => $programDayLog
    ]);
});

Route::put('/workout-program-day-logs/{log}', function (WorkoutLog $log, Request $request) {
    $log->fill($request->only('status'));
    $log->save();

    return redirect()->back();
});

Route::put('workout-program-day-exercise-set-logs/{log}', function (SetLog $log, Request $request) {
    $fill = $request->only(['reps', 'weight', 'duration']);

    $log->update($fill);

    return redirect()->back();
})->name('set-logs.update');

require __DIR__ . '/auth.php';
require __DIR__ . '/lift.php';
