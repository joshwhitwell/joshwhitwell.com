<?php

namespace App\Models\Lift;

use App\Models\Lift\Set;
use App\Models\Lift\Workout;
use App\Models\Lift\Exercise;
use App\Models\Lift\WorkoutExerciseLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutExercise extends Model
{
    protected $table = 'lift_workout_exercises';

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

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

    public function sets()
    {
        return $this->hasMany(Set::class)->orderByDesc('is_warm_up')->orderBy('order');
    }

    public function workoutExerciseLogs()
    {
        return $this->hasMany(WorkoutExerciseLog::class)->orderBy('order');
    }

    protected function restString(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->min_rest) && empty($this->max_rest)) {
                    return '';
                }

                $parts = array_filter([$this->min_rest, $this->max_rest]);
                $parts = array_unique($parts);
                $parts = array_map(function ($seconds) {
                    return $seconds / 60;
                }, $parts);

                sort($parts);

                $restTime = (string) (count($parts) === 1 ? $parts[0] : implode('–', $parts));

                return 'Rest: ' . $restTime . ($restTime === '1' ? ' min.' : ' mins.');
            }
        );
    }
}
