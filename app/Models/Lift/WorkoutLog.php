<?php

namespace App\Models\Lift;

use App\Models\Lift\Workout;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\WorkoutExerciseLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutLog extends Model
{
    protected $table = 'lift_workout_logs';

    protected $casts = [
        'status' => LiftStatus::class,
        'completed_at' => 'datetime',
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    public function workoutExerciseLogs()
    {
        return $this->hasMany(WorkoutExerciseLog::class);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return [
                    'status' => $value,
                    'completed_at' => $value === LiftStatus::Completed->value
                        ? now()
                        : null
                ];
            }
        );
    }
}
