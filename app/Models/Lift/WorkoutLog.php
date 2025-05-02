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
        'started_at' => 'datetime',
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
                $now = now();
                $updates = [
                    'status' => $value,
                ];

                switch ($value) {
                    case LiftStatus::NotStarted->value:
                        $updates['started_at'] = null;
                        $updates['completed_at'] = null;
                        break;

                    case LiftStatus::InProgress->value:
                        $updates['started_at'] = $now;
                        $updates['completed_at'] = null;
                        break;

                    case LiftStatus::Completed->value:
                        $updates['started_at'] = $this->started_at ?? $now;
                        $updates['completed_at'] = $now;
                        break;

                    case LiftStatus::Skipped->value:
                        $updates['started_at'] = $this->started_at;
                        $updates['completed_at'] = $now;
                        break;
                }

                return $updates;
            }
        );
    }

    protected function myProgramResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id',
                    'status'
                ]) + [
                    'name' => $this->workout->name,
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
                    'order',
                    'status'
                ]) + [
                    'startedAt' => $this->started_at?->format('M d, Y \a\t g:i A'),
                    'completedAt' => $this->completed_at?->format('M d, Y \a\t g:i A'),
                    'workoutExerciseLogs' => $this->workoutExerciseLogs->map(function ($workoutExerciseLog) {
                        $workoutExerciseLog->setRelation('workoutLog', $this);

                        return $workoutExerciseLog->only([
                            'id',
                            'name'
                        ]) + [
                            'notes' => $workoutExerciseLog->workoutExercise->notes,
                            'restString' => $workoutExerciseLog->workoutExercise->restString,
                            'videoUrl' => $workoutExerciseLog->workoutExercise->exercise->video_url,
                            'substitutionOne' => $workoutExerciseLog->workoutExercise->substitutionOne
                                ? [
                                    'name' => $workoutExerciseLog->workoutExercise->substitutionOne->name,
                                    'videoUrl' => $workoutExerciseLog->workoutExercise->substitutionOne->video_url,
                                ]
                                : null,
                            'substitutionTwo' => $workoutExerciseLog->workoutExercise->substitutionTwo
                                ? [
                                    'name' => $workoutExerciseLog->workoutExercise->substitutionTwo->name,
                                    'videoUrl' => $workoutExerciseLog->workoutExercise->substitutionTwo->video_url,
                                ]
                                : null,
                            'pastLogs' => $workoutExerciseLog->getPastLogs()->map(function ($workoutExerciseLog) {
                                $setLogs = $workoutExerciseLog->setLogs->pluck('myWorkoutResource');
                                $totalVolume = $setLogs->sum(function ($setLog) {
                                    return ($setLog['reps'] ?? 0) * ($setLog['weight'] ?? 0);
                                });
                                $setLogs = $setLogs->concat([['volume' => $totalVolume]]);

                                return $workoutExerciseLog->only(['id']) + [
                                    'setLogs' => $setLogs
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
