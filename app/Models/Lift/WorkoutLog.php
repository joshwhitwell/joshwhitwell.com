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
        'id' => 'integer',
        'user_id' => 'integer',
        'program_log_id' => 'integer',
        'phase_log_id' => 'integer',
        'week_log_id' => 'integer',
        'workout_id' => 'integer',
        'status' => LiftStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'order' => 'integer',
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
                    'statusLabel' => $this->status->label()
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
                            'name',
                            'status'
                        ]) + [
                            'startedAt' => $workoutExerciseLog->started_at?->format('M d, Y \a\t g:i A'),
                            'completedAt' => $workoutExerciseLog->completed_at?->format('M d, Y \a\t g:i A'),
                            'technique' => $workoutExerciseLog->workoutExercise->exercise->technique,
                            'notes' => $workoutExerciseLog->workoutExercise->notes,
                            'restString' => $workoutExerciseLog->workoutExercise->restString,
                            'videoUrl' => $workoutExerciseLog->workoutExercise->exercise->exerciseVideos->first()?->url,
                            'substitutionOne' => $workoutExerciseLog->workoutExercise->substitutionOne
                                ? [
                                    'name' => $workoutExerciseLog->workoutExercise->substitutionOne->name,
                                    'videoUrl' => $workoutExerciseLog->workoutExercise->substitutionOne->exerciseVideos->first()->url,
                                ]
                                : null,
                            'substitutionTwo' => $workoutExerciseLog->workoutExercise->substitutionTwo
                                ? [
                                    'name' => $workoutExerciseLog->workoutExercise->substitutionTwo->name,
                                    'videoUrl' => $workoutExerciseLog->workoutExercise->substitutionTwo->exerciseVideos->first()?->url,
                                ]
                                : null,
                            'pastLogs' => $workoutExerciseLog->getPastLogs()->map(function ($workoutExerciseLog) {
                                $setLogs = $workoutExerciseLog->setLogs->pluck('myWorkoutResource');
                                $totalVolume = $setLogs->contains('volume', '!==', null)
                                    ? round($setLogs->sum('volume'), 1)
                                    : null;
                                $isWhole = isset($totalVolume) && fmod($totalVolume, 1) === 0.0;
                                $totalVolume = isset($totalVolume) ? number_format($totalVolume, $isWhole ? 0 : 1) : '-';
                                $setLogs = $setLogs->concat([['volume' => $totalVolume]]);

                                return $workoutExerciseLog->only(['id']) + [
                                    'label' => $workoutExerciseLog->workout_log_id === $this->id
                                        ? 'Today'
                                        : $workoutExerciseLog?->workoutLog?->completed_at?->format('M j'),
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
