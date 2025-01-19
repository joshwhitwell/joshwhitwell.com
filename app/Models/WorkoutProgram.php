<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutProgram extends Model
{
    public function phases()
    {
        return $this->hasMany(WorkoutProgramPhase::class);
    }

    public function weeks()
    {
        return $this->hasMany(WorkoutProgramWeek::class);
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    protected function showResource(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'headTitle' => $this->name,
                'breadcrumbs' => [
                    [
                        'name' => $this->name,
                        'route' => route('workout-programs.show', $this->id)
                    ]
                ],
                'program' => [
                    'name' => $this->name,
                    'phases' => $this->phases->map(fn ($phase) => [
                        'name' => $phase->name,
                        'weeks' => $phase->weeks->map(fn ($week) => [
                            'name' => $week->name,
                            'route' => route('workout-programs.weeks.show', [
                                'program' => $this->id,
                                'week' => $week->id
                            ]),
                            'workouts' => $week->workouts->map(fn ($workout) => [
                                'name' => $workout->name,
                                'route' => route('workout-programs.weeks.workouts.show', [
                                    'program' => $this->id,
                                    'week' => $week->id,
                                    'workout' => $workout->id
                                ])
                            ])
                        ])
                    ]),
                ]
            ]
        );
    }
}
