<?php

namespace App\Models\Lift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Set extends Model
{
    protected $table = 'lift_sets';

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
                return !empty($this->rpe) ? 'RPE: ' . str_replace('~', '', $this->rpe) : '';
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
                    $this->intensity_technique
                ];
                $parts = array_filter($parts);
                return implode(' • ', $parts);
            }
        );
    }
}
