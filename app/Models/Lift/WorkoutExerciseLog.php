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
        return self::where('user_id', auth()->id())
            ->whereHas(
                'workoutLog',
                fn ($q) => $q->where('program_log_id', $this->workoutLog->program_log_id)
                    ->where('id', '!=', $this->workout_log_id)
                    ->where('order', '<', $this->workoutLog->order)
            )
            ->whereHas(
                'workoutExercise',
                fn ($q) => $q->where('exercise_id', $this->workoutExercise->exercise_id)
                    ->where('order', $this->workoutExercise->order)
            )
            ->orderBy('order')
            ->with([
                'setLogs.set.workoutExercise'
            ])
            ->get();
    }
}
