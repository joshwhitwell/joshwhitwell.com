<?php

namespace App\Models\Lift;

use App\Models\Lift\Set;
use App\Enums\Lift\LiftStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SetLog extends Model
{
    protected $table = 'lift_set_logs';

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'workout_exercise_log_id' => 'integer',
        'set_id' => 'integer',
        'reps' => 'integer',
        'weight' => 'float',
        'status' => LiftStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'order' => 'integer',
        'is_warm_up' => 'boolean',
    ];

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    public function volume(): Attribute
    {
        return Attribute::make(
            get: function () {
                return isset($this->weight) && isset($this->reps)
                    ? round(($this->reps ?? 0) * ($this->weight ?: 1), 1)
                    : null;
            }
        );
    }

    protected function myWorkoutResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id',
                    'order',
                    'reps',
                    'weight',
                    'volume',
                ]) + [
                    'isWarmUp' => $this->is_warm_up,
                    'isOptional' => $this->set->is_optional,
                    'repsRpeIntensity' => $this->set->reps_rpe_intensity,
                ];
            }
        );
    }
}
