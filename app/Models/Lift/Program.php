<?php

namespace App\Models\Lift;

use App\Models\Lift\Phase;
use App\Models\Lift\Workout;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'lift_programs';

    public function phases()
    {
        return $this->hasMany(Phase::class, 'lift_program_id')->orderBy('order');
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class, 'lift_program_id')->orderBy('order');
    }
}
