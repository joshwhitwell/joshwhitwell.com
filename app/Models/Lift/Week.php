<?php

namespace App\Models\Lift;

use App\Models\Lift\WeekLog;
use App\Models\Lift\Workout;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $table = 'lift_weeks';

    public function workouts()
    {
        return $this->hasMany(Workout::class)->orderBy('order');
    }

    public function weekLogs()
    {
        return $this->hasMany(WeekLog::class)->orderBy('order');
    }
}
