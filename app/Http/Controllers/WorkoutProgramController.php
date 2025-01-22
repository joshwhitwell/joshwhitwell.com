<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use Illuminate\Http\Request;
use App\Models\WorkoutProgram;
use App\Models\WorkoutProgramWeek;

class WorkoutProgramController extends Controller
{
    public function show(WorkoutProgram $program)
    {
        $program->load([
            'phases',
            'phases.weeks',
            'phases.weeks.workouts',
        ]);

        return view('workout-app.workout-program', $program->showResource);
    }

    public function showWeek(WorkoutProgram $program, WorkoutProgramWeek $week)
    {
        $week->load([
            'program',
            'workouts'
        ]);

        return view('workout-app.workout-program-week', $week->showResource);
    }

    public function showWorkout(WorkoutProgram $program, WorkoutProgramWeek $week, Workout $workout)
    {
        $workout->load([
            'program',
            'week',
            'workoutExercises',
            'workoutExercises.exercise',
            'workoutExercises.substitutionOne',
            'workoutExercises.substitutionTwo',
        ]);

        return view('workout-app.workout', $workout->showResource);
    }
}
