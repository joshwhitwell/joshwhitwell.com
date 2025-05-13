<?php

namespace App\Models\Lift;

use App\Models\Lift\Phase;
use App\Models\Lift\WeekLog;
use App\Enums\Lift\LiftStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PhaseLog extends Model
{
    protected $table = 'lift_phase_logs';

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'program_log_id' => 'integer',
        'phase_id' => 'integer',
        'status' => LiftStatus::class,
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'order' => 'integer',
    ];

    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    public function weekLogs()
    {
        return $this->hasMany(WeekLog::class)->orderBy('order');
    }

    protected function myProgramResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id'
                ]) + [
                    'name' => $this->phase->name,
                    'weekLogs' => $this->weekLogs->pluck('myProgramResource')
                ];
            }
        );
    }
}
