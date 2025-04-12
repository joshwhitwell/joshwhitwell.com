<?php

namespace App\Http\Controllers\Lift;

use App\Models\Lift\ProgramLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class MyProgramsController extends Controller
{
    public function index()
    {
        $programLogs = ProgramLog::myPrograms()
            ->paginate(10)
            ->through(function ($programLog) {
                return $programLog->toArray() + [
                    'myProgramRoute' => route('lift.my.programs.show', $programLog)
                ];
            });

        return inertia('Lift/MyPrograms', [
            'programLogs' => $programLogs,
        ]);
    }

    public function show(ProgramLog $programLog)
    {
        Gate::authorize('belongs-to-user', $programLog);

        $programLog->load([
            'program',
            'phaseLogs',
            'phaseLogs.phase',
            'phaseLogs.weekLogs.week',
            'phaseLogs.weekLogs.workoutLogs.workout',
        ]);

        $programLog->phaseLogs->each(fn ($phaseLog) =>
            $phaseLog->weekLogs->each(fn ($weekLog) =>
                $weekLog->workoutLogs->each(fn ($workoutLog) =>
                    $workoutLog->editRoute = route('lift.my.programs.workouts.edit', [$programLog, $workoutLog])
                )
            )
        );

        return inertia('Lift/MyProgram', [
            'programLog' => $programLog,
        ]);
    }
}
