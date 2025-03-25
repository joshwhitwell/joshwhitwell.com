<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkoutProgramDayExerciseSet;

class WorkoutProgramDayExerciseSetLog extends Model
{
    public function workoutProgramDayExerciseSet()
    {
        return $this->belongsTo(WorkoutProgramDayExerciseSet::class);
    }
}
