<?php

namespace App\Models\Lift;

use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'lift_workouts';

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class)->orderBy('order');
    }
}
