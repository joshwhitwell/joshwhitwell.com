<?php

namespace App\Models\Lift;

use App\Models\Lift\SetLog;
use App\Models\Lift\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Set extends Model
{
    protected $table = 'lift_sets';

    protected $casts = [
        'id' => 'integer',
        'workout_exercise_id' => 'integer',
        'order' => 'integer',
        'is_warm_up' => 'boolean',
        'is_optional' => 'boolean',
        'min_reps' => 'integer',
        'max_reps' => 'integer',
    ];

    public function workoutExercise()
    {
        return $this->belongsTo(WorkoutExercise::class);
    }

    public function setLogs()
    {
        return $this->hasMany(SetLog::class)->orderBy('order');
    }

    protected function repString(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->min_reps) && empty($this->max_reps)) {
                    return '';
                }

                $parts = array_filter([$this->min_reps, $this->max_reps]);
                $parts = array_unique($parts);

                sort($parts);

                return 'Reps: ' . (count($parts) === 1 ? $parts[0] : implode('–', $parts));
            }
        );
    }

    protected function rpeString(): Attribute
    {
        return Attribute::make(
            get: function () {
                return !empty($this->rpe) ? 'RPE: ' . str_replace(['~', '-'], ['', '–'], $this->rpe) : '';
            }
        );
    }

    protected function percentOneRepMaxString(): Attribute
    {
        return Attribute::make(
            get: function () {
                return !empty($this->percent_one_rep_max) ? $this->percent_one_rep_max . ' 1RM' : '';
            }
        );
    }

    protected function repsRpeIntensity(): Attribute
    {
        return Attribute::make(
            get: function () {
                $parts = [
                    $this->repString,
                    $this->rpeString,
                    $this->percentOneRepMaxString,
                    $this->workoutExercise->restString,
                    !empty($this->intensity_technique) ? ucfirst($this->intensity_technique) : ''
                ];
                $parts = array_filter($parts);
                return implode(' • ', $parts);
            }
        );
    }
}
