<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $guarded = [];

    public static $muscleGroups = [
        'chest',
        'shoulders',
        'traps',
        'biceps',
        'triceps',
        'back',
        'abs',
        'quads',
        'hamstrings',
        'glutes',
        'calves',
    ];

    public function exerciseLogs(): HasMany
    {
        return $this->hasMany(ExerciseLog::class);
    }
}
