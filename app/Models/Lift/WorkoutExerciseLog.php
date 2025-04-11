<?php

namespace App\Models\Lift;

use App\Models\Lift\SetLog;
use App\Models\Lift\WorkoutLog;
use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;

class WorkoutExerciseLog extends Model
{
    protected $table = 'lift_workout_exercise_logs';

    public function workoutLog()
    {
        return $this->belongsTo(WorkoutLog::class);
    }

    public function workoutExercise()
    {
        return $this->belongsTo(WorkoutExercise::class);
    }

    public function setLogs()
    {
        return $this->hasMany(SetLog::class);
    }
}
