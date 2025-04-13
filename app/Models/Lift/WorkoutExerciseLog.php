<?php

namespace App\Models\Lift;

use App\Models\Lift\SetLog;
use App\Models\Lift\WorkoutLog;
use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutExerciseLog extends Model
{
    protected $table = 'lift_workout_exercise_logs';

    public function workoutLog()
    {
        return $this->belongsTo(WorkoutLog::class);
    }

    public function workoutExercise()
    {
        return $this->belongsTo(WorkoutExercise::class);
    }

    public function setLogs()
    {
        return $this->hasMany(SetLog::class)->orderByDesc('is_warm_up')->orderBy('order');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->workoutExercise->exercise->name;
            }
        );
    }

    public function getPastLogs()
    {
        return self::where('workout_log_id', '!=', $this->workout_log_id)
            ->whereHas(
                'workoutExercise',
                fn ($q) => $q->where('exercise_id', $this->workoutExercise->exercise_id)
            )
            ->whereHas(
                'workoutLog',
                fn ($q) => $q->where('order', '<', $this->workoutLog->order)
            )
            ->orderBy('order')
            ->with([
                'setLogs.set'
            ])
            ->get();
    }
}
