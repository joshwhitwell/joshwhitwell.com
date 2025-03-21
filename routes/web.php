<?php

use App\Models\WorkoutLog;
use App\Models\ExerciseLog;
use Illuminate\Http\Request;
use App\Models\ExerciseSetLog;
use App\Models\WorkoutProgram;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $program = WorkoutProgram::find(1);
    
    return view('index', [
        'program' => $program
    ]);
});

Route::post('workout-logs', function (Request $request) {
    // Auth::login(User::find(1));
    // dd($request->all());

    // $fill = $request->validate([
    //     'exercise_id' => 'required|integer|exists:exercises,id',
    //     'user_id' => 'required|integer|exists:users,id',
    //     'sets' => 'required|array'
    // ]);

    $workoutLog = WorkoutLog::create([
        'user_id' => $request->user_id,
        'workout_id' => $request->workout_id,
    ]);

    foreach ($request->exercises as $exercise) {
        $exerciseLog = ExerciseLog::create([
            'user_id' => $request->user_id,
            'exercise_id' => $exercise['id'],
            'workout_log_id' => $workoutLog->id
        ]);

        foreach ($exercise['sets'] as $setNumber => $set) {
            ExerciseSetLog::create([
                'exercise_log_id' => $exerciseLog->id,
                'set_number' => $setNumber,
                'reps' => $set['reps'],
                'weight' => $set['weight'],
                'duration' => $set['duration'],
            ]);
        }
    }



    return redirect()->back();
})->name('workout-logs.store');
