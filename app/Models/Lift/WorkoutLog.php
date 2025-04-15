<?php

namespace App\Models\Lift;

use App\Models\Lift\Workout;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\WorkoutExerciseLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WorkoutLog extends Model
{
    protected $table = 'lift_workout_logs';

    protected $casts = [
        'status' => LiftStatus::class,
        'completed_at' => 'datetime',
    ];

    public function workout()
    {
        return $this->belongsTo(Workout::class);
    }

    public function workoutExerciseLogs()
    {
        return $this->hasMany(WorkoutExerciseLog::class)->orderBy('order');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->workout->name;
            }
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return [
                    'status' => $value,
                    'completed_at' => $value === LiftStatus::Completed->value
                        ? now()
                        : null
                ];
            }
        );
    }

    protected function myWorkoutResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id',
                    'name',
                ]) + [
                    'completedAt' => $this->completed_at?->format('M d, Y \a\t g:i A'),
                    'workoutExerciseLogs' => $this->workoutExerciseLogs->map(function ($workoutExerciseLog) {
                        $workoutExerciseLog->setRelation('workoutLog', $this);

                        return $workoutExerciseLog->only([
                            'id',
                            'name'
                        ]) + [
                            'notes' => $workoutExerciseLog->workoutExercise->notes,
                            'restString' => $workoutExerciseLog->workoutExercise->restString,
                            'pastLogs' => $workoutExerciseLog->getPastLogs()->map(function ($workoutExerciseLog) {
                                return $workoutExerciseLog->only(['id']) + [
                                    'setLogs' => $workoutExerciseLog->setLogs->pluck('myWorkoutResource')
                                ];
                            }),
                            'setLogs' => $workoutExerciseLog->setLogs->pluck('myWorkoutResource')
                        ];
                    })
                ];
            }
        );
    }
}
