<?php

namespace App\Models\Lift;

use App\Models\Lift\Set;
use Illuminate\Database\Eloquent\Model;

class SetLog extends Model
{
    protected $table = 'lift_set_logs';

    public function set()
    {
        return $this->belongsTo(Set::class, 'lift_set_id');
    }
}
