<?php

namespace App\Models;

use App\Models\WorkoutProgram;
use App\Models\WorkoutProgramDayLog;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgramLog extends Model
{
    public function workoutProgram()
    {
        return $this->belongsTo(WorkoutProgram::class);
    }

    public function workoutProgramDayLogs()
    {
        return $this->hasMany(WorkoutProgramDayLog::class);
    }
}
