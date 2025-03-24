<?php

namespace App\Models;

use App\Models\WorkoutProgramWeek;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgramPhase extends Model
{
    public function workoutProgramWeeks()
    {
        return $this->hasMany(WorkoutProgramWeek::class)->orderBy('order');
    }
}
