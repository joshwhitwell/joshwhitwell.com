<?php

namespace App\Models;

use App\Models\WorkoutProgramDay;
use App\Models\WorkoutProgramPhase;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgram extends Model
{
    public function workoutProgramPhases()
    {
        return $this->hasMany(WorkoutProgramPhase::class)->orderBy('order');
    }

    public function workoutProgramDays()
    {
        return $this->hasMany(WorkoutProgramDay::class)->orderBy('order');
    }
}
