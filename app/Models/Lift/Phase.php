<?php

namespace App\Models\Lift;

use App\Models\Lift\Week;
use App\Models\Lift\PhaseLog;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $table = 'lift_phases';

    protected $casts = [
        'id' => 'integer',
        'program_id' => 'integer',
        'order' => 'integer',
    ];

    public function weeks()
    {
        return $this->hasMany(Week::class)->orderBy('order');
    }

    public function phaseLogs()
    {
        return $this->hasMany(PhaseLog::class)->orderBy('order');
    }
}
