<?php

namespace App\Models\Lift;

use App\Enums\Lift\LiftStatus;
use App\Models\Lift\Workout;
use Illuminate\Support\Carbon;
use App\Models\Lift\WorkoutExerciseLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutLog extends Model
{
    protected $table = 'lift_workout_logs';

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    // public function programLog()
    // {
    //     return $this->belongsTo(ProgramLog::class, 'lift_program_log_id');
    // }

    public function workoutExerciseLogs()
    {
        return $this->hasMany(WorkoutExerciseLog::class);
    }

    // protected function completedAt(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($v) => $v ? Carbon::parse($v) : null,
    //     );
    // }

    // protected function status(): Attribute
    // {
    //     return Attribute::make(
    //         set: function ($value) {
    //             return [
    //                 'status' => $value,
    //                 'completed_at' => $value === LiftStatus::COMPLETED->value
    //                     ? now()
    //                     : null
    //             ];
    //         }
    //     );
    // }
}
