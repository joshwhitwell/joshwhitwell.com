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
            'workoutExerciseLogs.workoutExercise.substitutionOne',
            'workoutExerciseLogs.workoutExercise.substitutionTwo',
            'workoutExerciseLogs.setLogs.set.workoutExercise'
        ]);

        return inertia('Lift/MyWorkout', [
            'programLog' => $programLog->myProgramsResource,
            'workoutLog' => $workoutLog->myWorkoutResource,
            'liftStatus' => LiftStatus::options(),
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
