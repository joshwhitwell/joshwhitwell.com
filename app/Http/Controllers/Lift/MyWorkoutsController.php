<?php

namespace App\Http\Controllers\Lift;

use Illuminate\Http\Request;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\ProgramLog;
use App\Models\Lift\WorkoutLog;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class MyWorkoutsController extends Controller
{
    public function edit(ProgramLog $programLog, WorkoutLog $workoutLog)
    {
        Gate::authorize('belongs-to-user', $workoutLog);

        $workoutLog->load([
            'workoutExerciseLogs.workoutExercise.exercise',
            'workoutExerciseLogs.setLogs.set'
        ]);

        return view('lift.my.workout', [
            'programLog' => $programLog,
            'workoutLog' => $workoutLog,
            'updateWorkoutRoute' => route(
                'lift.my.programs.workouts.update',
                ['programLog' => $programLog, 'workoutLog' => $workoutLog]
            ),
            'liftStatus' => LiftStatus::class,
        ]);
    }

    public function update(Request $request, ProgramLog $programLog, WorkoutLog $workoutLog)
    {
        Gate::authorize('belongs-to-user', $workoutLog);

        $request->validate([
            'status' => [Rule::enum(LiftStatus::class)]
        ]);

        $workoutLog->update($request->only('status'));

        return redirect()->action([self::class, 'edit'], [$programLog, $workoutLog]);
    }
}
