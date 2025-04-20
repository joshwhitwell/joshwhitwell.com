<?php

namespace App\Models\Lift;

use App\Models\Lift\Program;
use App\Models\Lift\WorkoutLog;
use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'lift_workouts';

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class)->orderBy('order');
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class)->orderBy('order');
    }
}
