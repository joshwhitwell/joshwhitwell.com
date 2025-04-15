<?php

namespace App\Models\Lift;

use App\Models\Lift\Set;
use App\Models\Lift\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutExercise extends Model
{
    protected $table = 'lift_workout_exercises';

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function sets()
    {
        return $this->hasMany(Set::class)->orderByDesc('is_warm_up')->orderBy('order');
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

                return $restTime . ($restTime === '1' ? ' min' : ' mins');
            }
        );
    }
}
