<?php

namespace App\Models\Lift;

use App\Models\Lift\Set;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SetLog extends Model
{
    protected $table = 'lift_set_logs';

    public function set()
    {
        return $this->belongsTo(Set::class);
    }

    protected function myWorkoutResource(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->only([
                    'id',
                    'order',
                    'reps',
                    'weight'
                ]) + [
                    'isWarmUp' => $this->is_warm_up,
                    'isOptional' => $this->set->is_optional
                ];
            }
        );
    }
}
