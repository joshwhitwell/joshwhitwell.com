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

    protected $casts = [
        'id' => 'integer',
        'workout_id' => 'integer',
        'exercise_id' => 'integer',
        'order' => 'integer',
        'min_rest' => 'integer',
        'max_rest' => 'integer',
        'substitution_1_id' => 'integer',
        'substitution_2_id' => 'integer',
    ];

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

                sort($parts);

                // Format each value with appropriate unit
                $units = [];
                $formattedParts = [];

                foreach ($parts as $seconds) {
                    if ($seconds < 60) {
                        $units[] = 'sec';
                        $formattedParts[] = $seconds;
                    } else {
                        $units[] = 'min';
                        $formattedParts[] = $seconds / 60;
                    }
                }

                // If we have exactly two parts with the same unit
                if (count($units) == 2 && $units[0] === $units[1]) {
                    $unit = $units[0] === 'sec' ?
                            ($formattedParts[1] === 1 ? ' sec' : ' secs') :
                            ($formattedParts[1] === 1 ? ' min' : ' mins');
                    return 'Rest: ' . $formattedParts[0] . '–' . $formattedParts[1] . $unit;
                } else {
                    // Different units or just one value
                    $result = [];
                    foreach ($formattedParts as $i => $value) {
                        $suffix = $units[$i] === 'sec' ?
                                 ($value === 1 ? ' sec' : ' secs') :
                                 ($value === 1 ? ' min' : ' mins');
                        $result[] = $value . $suffix;
                    }
                    return 'Rest: ' . implode('–', $result);
                }
            }
        );
    }
}
