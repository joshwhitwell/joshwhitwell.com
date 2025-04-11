<?php

namespace App\Models\Lift;

use App\Models\Lift\Week;
use App\Models\Lift\WorkoutLog;
use Illuminate\Database\Eloquent\Model;

class WeekLog extends Model
{
    protected $table = 'lift_week_logs';

    public function week()
    {
        return $this->belongsTo(Week::class);
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class)->orderBy('order');;
    }
}
