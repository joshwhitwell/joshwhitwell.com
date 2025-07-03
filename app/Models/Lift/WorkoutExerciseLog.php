<?php

namespace App\Models\Lift;

use App\Enums\Lift\LiftStatus;
use App\Models\Lift\SetLog;
use App\Models\Lift\WorkoutLog;
use App\Models\Lift\WorkoutExercise;
use App\Traits\HasLiftStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutExerciseLog extends Model
{
    use HasLiftStatus;
    
    protected $table = 'lift_workout_exercise_logs';

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'workout_log_id' => 'integer',
        'workout_exercise_id' => 'integer',
        'status' => LiftStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'order' => 'integer',
    ];

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
                    ->where('order', '<=', $this->workoutLog->order)
            )
            ->whereHas(
                'workoutExercise',
                fn ($q) => $q->where('exercise_id', $this->workoutExercise->exercise_id)
                    ->where('order', $this->workoutExercise->order)
            )
            ->whereHas(
                'setLogs',
                fn ($q) => $q->whereNotNull('reps')->orWhereNotNull('weight')
            )
            ->orderByRaw('CASE WHEN completed_at IS NULL THEN 0 ELSE 1 END')
            ->orderBy('completed_at', 'desc')
            ->orderBy('order')
            ->with([
                'workoutLog',
                'setLogs.set.workoutExercise'
            ])
            ->get();
    }
}
