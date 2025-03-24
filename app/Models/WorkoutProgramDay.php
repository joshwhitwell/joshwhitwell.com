<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkoutProgramDayExercise;

class WorkoutProgramDay extends Model
{
    public function workoutProgramDayExercises()
    {
        return $this->hasMany(WorkoutProgramDayExercise::class)->orderBy('order');
    }
}
