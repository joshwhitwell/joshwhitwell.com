<?php

namespace App\Models;

use App\Models\WorkoutProgramDay;
use App\Models\WorkoutProgramLog;
use App\Enums\WorkoutProgramStatus;
use Illuminate\Database\Eloquent\Model;
use App\Models\WorkoutProgramDayExerciseLog;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutProgramDayLog extends Model
{
    protected function casts()
    {
        return [
            'completed_at' => 'datetime'
        ];
    }
    
    public function workoutProgramDay()
    {
        return $this->belongsTo(WorkoutProgramDay::class);
    }

    public function workoutProgramLog()
    {
        return $this->belongsTo(WorkoutProgramLog::class);
    }

    public function workoutProgramDayExerciseLogs()
    {
        return $this->hasMany(WorkoutProgramDayExerciseLog::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return [
                    'status' => $value,
                    'completed_at' => $value === WorkoutProgramStatus::COMPLETED->value
                        ? now()
                        : null
                ];
            }
        );
    }
}
