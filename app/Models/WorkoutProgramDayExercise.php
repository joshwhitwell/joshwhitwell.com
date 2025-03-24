<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WorkoutProgramDayExerciseSet;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutProgramDayExercise extends Model
{
    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function substitutionOne()
    {
        return $this->belongsTo(Exercise::class, 'substitution_1_id');
    }

    public function substitutionTwo()
    {
        return $this->belongsTo(Exercise::class, 'substitution_2_id');
    }

    public function workoutProgramDayExerciseSets()
    {
        return $this->hasMany(WorkoutProgramDayExerciseSet::class)->orderByDesc('is_warm_up')->orderBy('order');
    }

    protected function restString(): Attribute
    {
        return Attribute::make(
            get: function () {
                $range = array_filter(array_unique([
                    ($this->min_rest ?? 0) / 60,
                    ($this->max_rest ?? 0) / 60
                ]));

                if (empty($range)) {
                    return null;
                }

                sort($range);

                return 'Rest ~' . implode('–', $range) . 'mins';
            }
        );
    }
}
