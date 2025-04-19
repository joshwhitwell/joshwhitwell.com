<?php

namespace App\Models\Lift;

use App\Models\Lift\Program;
use App\Models\Lift\PhaseLog;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\WorkoutLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ProgramLog extends Model
{
    protected $table = 'lift_program_logs';


    protected $casts = [
        'status' => LiftStatus::class,
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function phaseLogs()
    {
        return $this->hasMany(PhaseLog::class)->orderBy('order');;
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class)->orderBy('order');;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->program->name;
            }
        );
    }

    protected function myProgramsResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id',
                ]) + [
                    'name' => $this->program->name,
                    'status' => $this->status,
                    'statusLabel' => $this->status->label(),
                    'completedWorkoutCount' => $this->workoutLogs()->where('status', LiftStatus::Completed)->count(),
                    'totalWorkoutCount' => $this->workoutLogs()->count()
                ];
            }
        );
    }

    protected function myProgramResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id',
                ]) + [
                    'name' => $this->program->name,
                    'phaseLogs' => $this->phaseLogs->map(function ($phaseLog) {
                        return $phaseLog->only([
                            'id'
                        ]) + [
                            'name' => $phaseLog->phase->name,
                            'weekLogs' => $phaseLog->weekLogs->map(function ($weekLog) {
                                return $weekLog->only([
                                    'id'
                                ]) + [
                                    'name' => $weekLog->week->name,
                                    'workoutLogs' => $weekLog->workoutLogs->map(function ($workoutLog) {
                                        return $workoutLog->only([
                                            'id'
                                        ]) + [
                                            'name' => $workoutLog->workout->name,
                                            'completedAt' => $workoutLog->completed_at
                                        ];
                                    })
                                ];
                            })
                        ];
                    })
                ];
            }
        );
    }

    public function scopeMyPrograms($query)
    {
        return $query->select(['id', 'program_id', 'status'])
            ->with([
                'program' => fn ($q) => $q->select(['id', 'name'])
            ])
            ->where('user_id', auth()->id())
            ->orderByRaw(LiftStatus::orderBy())
            ->orderByDesc('updated_at');
    }
}
