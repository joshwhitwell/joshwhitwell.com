<?php

namespace App\Http\Controllers\Lift;

use Illuminate\Http\Request;
use App\Models\Lift\ProgramLog;
use App\Models\Lift\WorkoutLog;
use App\Http\Controllers\Controller;

class MyProgramsController extends Controller
{
    public function index()
    {
        $programLogs = ProgramLog::myPrograms()->paginate(10);

        return view('lift.my.programs', [
            'programLogs' => $programLogs,
        ]);
    }

    public function show(ProgramLog $programLog)
    {
        $programLog->load([
            'phaseLogs.phase',
            'phaseLogs.weekLogs.week',
            'phaseLogs.weekLogs.workoutLogs.workout',
        ]);

        return view('lift.my.program', [
            'programLog' => $programLog,
        ]);
    }
}
