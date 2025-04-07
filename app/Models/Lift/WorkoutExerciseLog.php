<?php

namespace App\Models\Lift;

use App\Models\Lift\SetLog;
use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;

class WorkoutExerciseLog extends Model
{
    protected $table = 'lift_workout_exercise_logs';

    public function workoutExercise()
    {
        return $this->belongsTo(WorkoutExercise::class, 'lift_workout_exercise_id');
    }

    public function setLogs()
    {
        return $this->hasMany(SetLog::class, 'lift_workout_exercise_log_id');
    }
}
