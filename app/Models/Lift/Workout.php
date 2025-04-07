<?php

namespace App\Models\Lift;

use App\Models\Lift\WorkoutLog;
use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $table = 'lift_workouts';

    public function exercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'lift_workout_id')->orderBy('order');
    }

    public function scopeWithWorkoutLogId($query, $programLogId)
    {
        return $query->addSelect([
            'workout_log_id' => WorkoutLog::select('id')
                ->where('user_id', 1)
                ->whereColumn('lift_workout_id', 'lift_workouts.id')
                ->where('lift_program_log_id', $programLogId)
                ->latest()
                ->take(1)
        ]);
    }
}
