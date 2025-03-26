<?php

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\WorkoutProgram;
use App\Models\WorkoutProgramLog;
use App\Enums\WorkoutProgramStatus;
use App\Models\WorkoutProgramDayLog;
use Illuminate\Support\Facades\Route;
use App\Models\WorkoutProgramDayExerciseSet;
use App\Models\WorkoutProgramDayExerciseSetLog;

Route::get('/my/programs', function () {
    $programLogs = WorkoutProgramLog::with(['workoutProgram'])->where('user_id', 1)->get();

    return view('my-programs', [
        'programLogs' => $programLogs,
    ]);
});

Route::get('/my/programs/{programLog}', function (WorkoutProgramLog $programLog) {
    $programLog->load([
        'workoutProgram' => fn ($q) => $q->select(['id', 'name']),
        'workoutProgram.workoutProgramPhases' => fn ($q) => $q->select(['id', 'workout_program_id', 'name']),
        'workoutProgram.workoutProgramPhases.workoutProgramWeeks' => fn ($q) => $q->select(['id', 'workout_program_phase_id', 'name']),
        'workoutProgram.workoutProgramPhases.workoutProgramWeeks.workoutProgramDays' => fn ($q) => $q->select(['id', 'workout_program_week_id', 'name'])->addSelect([
            'workout_program_day_log_id' => WorkoutProgramDayLog::select('id')
                ->where('user_id', 1)
                ->whereColumn('workout_program_day_id', 'workout_program_days.id')
                ->where('workout_program_log_id', $programLog->id)
                ->latest()
                ->take(1)
            ])
    ]);

    return view('my-program', [
        'programLog' => $programLog,
    ]);
});

Route::get('/my/programs/{programLog}/days/{programDayLog}', function (WorkoutProgramLog $programLog, WorkoutProgramDayLog $programDayLog) {
    $programDayLog->load([
        'workoutProgramDayExerciseLogs',
        'workoutProgramDayExerciseLogs.workoutProgramDayExercise',
        'workoutProgramDayExerciseLogs.workoutProgramDayExercise.exercise',
        'workoutProgramDayExerciseLogs.workoutProgramDayExerciseSetLogs',
        'workoutProgramDayExerciseLogs.workoutProgramDayExerciseSetLogs.workoutProgramDayExerciseSet'
    ]);

    return view('program-day', [
        'programDayLog' => $programDayLog
    ]);
});

Route::put('/workout-program-day-logs/{log}', function (WorkoutProgramDayLog $log, Request $request) {
    $log->fill($request->only('status'));
    $log->save();
    
    return redirect()->back();
});

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

Route::put('workout-program-day-exercise-set-logs/{log}', function (WorkoutProgramDayExerciseSetLog $log, Request $request) {
    $fill = $request->only(['reps', 'weight', 'duration']);

    $log->update($fill);

    return redirect()->back();
})->name('set-logs.update');
