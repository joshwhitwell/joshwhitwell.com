<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutProgramPhase extends Model
{
    public function weeks()
    {
        return $this->hasMany(WorkoutProgramWeek::class);
    }
}
