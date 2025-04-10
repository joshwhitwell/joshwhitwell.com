<?php

namespace App\Models\Lift;

use App\Models\Lift\Program;
use App\Enums\Lift\LiftStatus;
use Illuminate\Database\Eloquent\Model;

class ProgramLog extends Model
{
    protected $table = 'lift_program_logs';

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function phaseLogs()
    {
        return $this->hasMany(PhaseLog::class);
    }

    public function scopeMyPrograms($query)
    {
        return $query->with(['program'])
            ->where('user_id', auth()->id())
            ->orderByRaw(LiftStatus::orderBy())
            ->orderByDesc('updated_at');
    }
}
