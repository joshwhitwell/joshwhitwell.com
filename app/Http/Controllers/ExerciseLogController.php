<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Http\Requests\StoreExerciseLogRequest;

class ExerciseLogController extends Controller
{
    public function store(StoreExerciseLogRequest $request, Exercise $exercise)
    {
        $exercise->exerciseLogs()->create($request->validated());

        return to_route('exercises.show', $exercise);
    }
}
