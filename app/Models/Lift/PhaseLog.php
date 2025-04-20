<?php

namespace App\Models\Lift;

use App\Models\Lift\Phase;
use App\Models\Lift\WeekLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PhaseLog extends Model
{
    protected $table = 'lift_phase_logs';

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
