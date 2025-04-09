<?php

namespace App\Models\Lift;

use App\Models\Lift\Program;
use App\Enums\Lift\LiftStatus;
use App\Models\Lift\WorkoutLog;
use Illuminate\Database\Eloquent\Model;

class ProgramLog extends Model
{
    protected $table = 'lift_program_logs';

    public function program()
    {
        return $this->belongsTo(Program::class, 'lift_program_id');
    }

    public function workoutLogs()
    {
        return $this->hasMany(WorkoutLog::class);
    }

    public function scopeMyPrograms($query)
    {
        return $query->with(['program'])
            ->where('user_id', auth()->id())
            ->orderByRaw(LiftStatus::orderBy())
            ->orderByDesc('updated_at');
    }

    public function scopeMyProgram($query)
    {
        return $query->with(['program'])
            ->where('user_id', auth()->id())
            ->orderByRaw(LiftStatus::orderBy())
            ->orderByDesc('updated_at');
    }
}
