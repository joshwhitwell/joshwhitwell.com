<?php

namespace App\Models\Lift;

use App\Models\Lift\ExerciseVideo;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'lift_exercises';

    protected $casts = [
        'id' => 'integer',
    ];
    
    public function exerciseVideos()
    {
        return $this->hasMany(ExerciseVideo::class);
    }
}
