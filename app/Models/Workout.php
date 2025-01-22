<?php

namespace App\Models;

use App\Models\WorkoutExercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Workout extends Model
{
    public function program()
    {
        return $this->belongsTo(WorkoutProgram::class, 'workout_program_id');
    }

    public function week()
    {
        return $this->belongsTo(WorkoutProgramWeek::class, 'workout_program_week_id');
    }

    public function workoutExercises()
    {
        return $this->hasMany(WorkoutExercise::class)
            ->orderBy('order');
    }

    protected function showResource(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                'headTitle' => implode(' | ', [
                    $this->name,
                    $this->week->name,
                    $this->program->name,
                ]),
                'breadcrumbs' => [
                    [
                        'name' => $this->program->name,
                        'route' => route('workout-programs.show', $this->workout_program_id)
                    ],
                    [
                        'name' => $this->week->name,
                        'route' => route('workout-programs.weeks.show', [
                            'program' => $this->workout_program_id,
                            'week' => $this->workout_program_week_id
                        ])
                    ],
                    [
                        'name' => $this->name,
                        'route' => route('workout-programs.weeks.workouts.show', [
                            'program' => $this->workout_program_id,
                            'week' => $this->workout_program_week_id,
                            'workout' => $this->id
                        ])
                    ]
                ],
                'workout' => [
                    'name' => $this->name,
                    'exercises' => $this->workoutExercises->map(
                        fn ($workoutExercise) => $workoutExercise->showResource
                    )
                ]
            ]
        );
    }
}
