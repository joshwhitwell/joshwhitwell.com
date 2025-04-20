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
                return $programLog->myProgramsResource;
            });

        return inertia('Lift/MyPrograms', [
            'programLogs' => $programLogs,
        ]);
    }

    public function show(ProgramLog $programLog)
    {
        Gate::authorize('belongs-to-user', $programLog);

        $programLog->load([
            'phaseLogs.phase',
            'phaseLogs.weekLogs.week',
            'phaseLogs.weekLogs.workoutLogs.workout',
        ]);

        if ($programLog->phaseLogs->isEmpty()) {
            $programLog->load([
                'weekLogs.week',
                'weekLogs.workoutLogs.workout'
            ]);
        }

        return inertia('Lift/MyProgram', [
            'programLog' => $programLog->myProgramResource,
        ]);
    }
}
