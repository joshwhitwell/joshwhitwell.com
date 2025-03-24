<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutProgramDayExerciseSetLog extends Model
{
    public function scopeWithPreviousLog($query)
    {
        return $query->addSelect([
            'previous_log' => WorkoutProgramDayExerciseSetLog::select('id')
                ->whereColumn('user_id', 'workout_program_day_exercise_set_logs.user_id')
                // ->whereColumn('exercise_id', 'workout_program_day_exercise_set_logs.exercise_id')
                ->orderBy('created_at', 'desc')
                ->limit(1)
        ]);
    }
}
