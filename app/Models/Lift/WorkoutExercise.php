<?php

namespace App\Models\Lift;

use App\Models\Lift\Set;
use App\Models\Lift\Exercise;
use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    protected $table = 'lift_workout_exercises';

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function sets()
    {
        return $this->hasMany(Set::class)->orderByDesc('is_warm_up')->orderBy('order');
    }
}
