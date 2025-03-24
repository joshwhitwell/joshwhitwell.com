<?php

namespace App\Models;

use App\Models\WorkoutProgramDay;
use Illuminate\Database\Eloquent\Model;

class WorkoutProgramWeek extends Model
{
    public function workoutProgramDays()
    {
        return $this->hasMany(WorkoutProgramDay::class)->orderBy('order');
    }
}
