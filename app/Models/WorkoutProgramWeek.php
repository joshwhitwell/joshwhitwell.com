<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutProgramWeek extends Model
{
    public function program()
    {
        return $this->belongsTo(WorkoutProgram::class, 'workout_program_id');
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class);
    }

    protected function showResource(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'headTitle' => implode(' | ', [
                    $this->name,
                    $this->program->name,
                ]),
                'breadcrumbs' => [
                    [
                        'name' => $this->program->name,
                        'route' => route('workout-programs.show', $this->workout_program_id)
                    ],
                    [
                        'name' => $this->name,
                        'route' => route('workout-programs.weeks.show', [
                            'program' => $this->workout_program_id,
                            'week' => $this->id
                        ])
                    ]
                ],
                'week' => [
                    'name' => $this->name,
                    'workouts' => $this->workouts->map(fn ($workout) => [
                        'name' => $workout->name,
                        'route' => route('workout-programs.weeks.workouts.show', [
                            'program' => $this->workout_program_id,
                            'week' => $this->id,
                            'workout' => $workout->id
                        ])
                    ])
                ]
            ]
        );
    }
}
