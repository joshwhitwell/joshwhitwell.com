<?php

namespace App\Http\Controllers\Lift;

use Illuminate\Http\Request;
use App\Models\Lift\ProgramLog;
use App\Models\Lift\WorkoutLog;
use App\Http\Controllers\Controller;

class MyWorkoutsController extends Controller
{
    public function edit(ProgramLog $programLog, WorkoutLog $workoutLog)
    {
        $workoutLog->load([
            'workoutExerciseLogs.workoutExercise.exercise',
            'workoutExerciseLogs.setLogs.set'
        ]);

        return view('lift.my.workout', [
            'programLog' => $programLog,
            'workoutLog' => $workoutLog
        ]);
    }
}
