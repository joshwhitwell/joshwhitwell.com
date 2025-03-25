<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkoutProgramDayExercise;
use App\Models\WorkoutProgramDayExerciseSetLog;

class WorkoutProgramDayExerciseLog extends Model
{
    public function workoutProgramDayExercise()
    {
        return $this->belongsTo(WorkoutProgramDayExercise::class);
    }

    public function workoutProgramDayExerciseSetLogs()
    {
        return $this->hasMany(WorkoutProgramDayExerciseSetLog::class);
    }
}
