<?php

namespace App\Http\Controllers\Lift;

use Illuminate\Http\Request;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\ProgramLog;
use App\Models\Lift\WorkoutLog;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Models\Lift\WorkoutExerciseLog;

class MyExercisesController extends Controller
{
    public function update(Request $request, ProgramLog $programLog, WorkoutLog $workoutLog, WorkoutExerciseLog $exerciseLog)
    {
        Gate::authorize('belongs-to-user', $exerciseLog);

        $request->validate([
            'status' => [Rule::enum(LiftStatus::class)]
        ]);

        $exerciseLog->update($request->only('status'));

        return redirect()->route('lift.my.programs.workouts.edit', [$programLog, $workoutLog]);
    }
}
