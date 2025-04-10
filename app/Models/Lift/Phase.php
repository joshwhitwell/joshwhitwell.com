<?php

namespace App\Models\Lift;

use App\Models\Lift\Week;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $table = 'lift_phases';

    public function weeks()
    {
        return $this->hasMany(Week::class)->orderBy('order');
    }
}
