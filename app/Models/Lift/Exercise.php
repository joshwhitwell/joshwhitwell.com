<?php

namespace App\Models\Lift;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'lift_exercises';

    protected $casts = [
        'id' => 'integer',
    ];
}
