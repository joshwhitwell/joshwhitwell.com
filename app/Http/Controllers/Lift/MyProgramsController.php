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
            'program' => fn($q) => $q->select(['id', 'name']),
            'program.phases' => fn($q) => $q->select(['id', 'lift_program_id', 'name']),
            'program.phases.weeks' => fn($q) => $q->select(['id', 'lift_phase_id', 'name']),
            'program.phases.weeks.workouts' => fn($q) => $q->select(['id', 'lift_week_id', 'name'])
                ->withWorkoutLogId($programLog->id)
        ]);

        return view('lift.my.program', [
            'programLog' => $programLog,
        ]);
    }
}
