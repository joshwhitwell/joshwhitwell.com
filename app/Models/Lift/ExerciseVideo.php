<?php

namespace App\Models\Lift;

use Illuminate\Database\Eloquent\Model;

class ExerciseVideo extends Model
{
    protected $table = 'lift_exercise_videos';

    public $timestamps = false;

    protected $casts = [
        'id' => 'integer',
        'exercise_id' => 'integer',
    ];

    protected $fillable = [
        'url',
    ];
}
