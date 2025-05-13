<?php

namespace App\Models\Lift;

use App\Enums\Lift\LiftStatus;
use App\Models\Lift\Week;
use App\Models\Lift\WorkoutLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class WeekLog extends Model
{
    protected $table = 'lift_week_logs';

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'program_log_id' => 'integer',
        'phase_log_id' => 'integer',
        'week_id' => 'integer',
        'status' => LiftStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'order' => 'integer',
    ];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class)->orderBy('order');;
    }

    protected function myProgramResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id'
                ]) + [
                    'name' =>  $this->week->name,
                    'workoutLogs' =>   $this->workoutLogs->pluck('myProgramResource')
                ];
            }
        );
    }
}
