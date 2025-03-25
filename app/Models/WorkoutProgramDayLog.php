<?php

namespace App\Models;

use App\Models\WorkoutProgramDay;
use App\Models\WorkoutProgramLog;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkoutProgramDayExerciseLog;

class WorkoutProgramDayLog extends Model
{
    public function workoutProgramDay()
    {
        return $this->belongsTo(WorkoutProgramDay::class);
    }

    public function workoutProgramLog()
    {
        return $this->belongsTo(WorkoutProgramLog::class);
    }

    public function workoutProgramDayExerciseLogs()
    {
        return $this->hasMany(WorkoutProgramDayExerciseLog::class);
    }
}
