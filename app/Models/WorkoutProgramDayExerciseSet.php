<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutProgramDayExerciseSet extends Model
{
    public function log()
    {
        return $this->hasOne(WorkoutProgramDayExerciseSetLog::class)->where('user_id', auth()->id());
    }

    protected function repString(): Attribute
    {
        return Attribute::make(
            get: function () {
                $range = array_filter(array_unique([
                    ($this->min_reps ?? 0),
                    ($this->max_reps ?? 0)
                ]));

                if (empty($range)) {
                    return null;
                }

                sort($range);

                return 'Reps: ' . implode('–', $range);
            }
        );
    }
}
