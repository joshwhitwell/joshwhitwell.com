<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExerciseWorkout extends Pivot
{
    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'reps' => 'array',
        ];
    }

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    public function substitutionOne()
    {
        return $this->belongsTo(Exercise::class, 'sub_1_id');
    }

    public function substitutionTwo()
    {
        return $this->belongsTo(Exercise::class, 'sub_2_id');
    }

    protected function showResource(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'name' => optional($this->exercise)->name,
                'url' => optional($this->exercise)->url,
                'notes' => $this->notes,
                'substitutionOne' => optional($this->substitutionOne)->only(['name', 'url']),
                'substitutionTwo' => optional($this->substitutionTwo)->only(['name', 'url']),
                'minWarmUpSets' => $this->min_warm_up_sets,
                'maxWarmUpSets' => $this->max_warm_up_sets,
                'minSets' => $this->min_sets,
                'maxSets' => $this->max_sets,
                'lastSetIntensityTechnique' => $this->last_set_intensity_technique,
                'rpeRepsRest' => $this->rpeRepsRest,
            ]
        );
    }

    protected function rpeRepsRest(): Attribute
    {
        return Attribute::make(
            get: fn () => collect()
                ->range(1, $this->max_sets)
                ->reduce(function ($acc, $set) {
                    $acc[$set] = collect([
                        'rpe' => $set === $this->max_sets && !empty($this->last_set_rpe)
                            ? 'RPE ' . $this->last_set_rpe
                            : ($set < $this->max_sets && !empty($this->early_set_rpe)
                                ? 'RPE ' . $this->early_set_rpe
                                : null
                            ),
                        'reps' => !empty($this->reps[0])
                            ? (count($this->reps) === 1
                                ? $this->reps[0]
                                : ($this->reps[$set - 1] ?? $this->reps[0])
                            ) . ' Reps'
                            : null,
                        'rest' => !empty($this->min_rest) || !empty($this->max_rest)
                            ? 'Rest ' . collect([$this->min_rest, $this->max_rest])
                                ->filter()
                                ->map(fn ($seconds) => $seconds / 60)
                                ->implode('–') . ' mins.'
                            : null,
                    ])
                        ->filter()
                        ->implode(' &middot; ');

                    return $acc;
                }, [])
        );
    }
}
