<?php

use App\Models\User;
use App\Models\WorkoutLog;
use App\Models\ExerciseLog;
use Illuminate\Http\Request;
use App\Models\ExerciseSetLog;
use App\Models\WorkoutProgram;
use Illuminate\Support\Facades\Route;
use App\Models\WorkoutProgramDayExerciseSet;
use App\Models\WorkoutProgramDayExerciseSetLog;

Route::get('/', function () {
    $program = WorkoutProgram::with([
        'workoutProgramPhases' => fn ($q) => $q->take(1),
        'workoutProgramPhases.workoutProgramWeeks' => fn ($q) => $q->take(2),
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays' => fn ($q) => $q->take(1),
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays.workoutProgramDayExercises',
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays.workoutProgramDayExercises.exercise',
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays.workoutProgramDayExercises.substitutionOne',
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays.workoutProgramDayExercises.substitutionTwo',
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays.workoutProgramDayExercises.workoutProgramDayExerciseSets',
        'workoutProgramPhases.workoutProgramWeeks.workoutProgramDays.workoutProgramDayExercises.workoutProgramDayExerciseSets.log' => fn ($q) => $q
    ])->find(1);

    // dd($program->workoutProgramPhases->first()->workoutProgramWeeks->first()->workoutProgramDays->first()->workoutProgramDayExercises->first()->);

    return view('index', [
        'program' => $program
    ]);
});

Route::post('workout-program-day-exercise-sets/{workoutProgramDayExerciseSet}/workout-program-day-exercise-set-logs', function (WorkoutProgramDayExerciseSet $workoutProgramDayExerciseSet, Request $request) {
    // dd($request->all());
    Auth::login(User::find(1));

    WorkoutProgramDayExerciseSetLog::updateOrCreate([
        'user_id' => auth()->id(),
        'workout_program_day_exercise_set_id' => $workoutProgramDayExerciseSet->id,
    ],
        $request->only(['reps', 'weight'])
    );
    // dd($request->all());

    // $fill = $request->validate([
    //     'exercise_id' => 'required|integer|exists:exercises,id',
    //     'user_id' => 'required|integer|exists:users,id',
    //     'sets' => 'required|array'
    // ]);

    // $workoutLog = WorkoutLog::create([
    //     'user_id' => $request->user_id,
    //     'workout_id' => $request->workout_id,
    // ]);

    // foreach ($request->exercises as $exercise) {
    //     $exerciseLog = ExerciseLog::create([
    //         'user_id' => $request->user_id,
    //         'exercise_id' => $exercise['id'],
    //         'workout_log_id' => $workoutLog->id
    //     ]);

    //     foreach ($exercise['sets'] as $setNumber => $set) {
    //         ExerciseSetLog::create([
    //             'exercise_log_id' => $exerciseLog->id,
    //             'set_number' => $setNumber,
    //             'reps' => $set['reps'],
    //             'weight' => $set['weight'],
    //             'duration' => $set['duration'],
    //         ]);
    //     }
    // }




    return redirect()->back();
})->name('set-logs.store');
