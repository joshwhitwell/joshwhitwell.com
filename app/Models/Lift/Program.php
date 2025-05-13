<?php

namespace App\Models\Lift;

use App\Models\Lift\Week;
use App\Models\Lift\Phase;
use Illuminate\Support\Str;
use App\Models\Lift\Workout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Program extends Model
{
    protected $table = 'lift_programs';

    protected $casts = [
        'id' => 'integer',
    ];

    public function phases()
    {
        return $this->hasMany(Phase::class)->orderBy('order');
    }

    public function weeks()
    {
        return $this->hasMany(Week::class)->orderBy('order');
    }

    public function workouts()
    {
        return $this->hasMany(Workout::class)->orderBy('order');
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value),
        );
    }
}
