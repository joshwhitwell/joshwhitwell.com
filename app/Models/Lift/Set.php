<?php

namespace App\Models\Lift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Set extends Model
{
    protected $table = 'lift_sets';

    public function log()
    {
        return $this->hasOne(SetLog::class)->where('user_id', auth()->id());
    }

    protected function repString(): Attribute
    {
        return Attribute::make(
            get: function () {
                $range = array_filter(array_unique([
                    ($this->min_reps ?? 0),
                    ($this->max_reps ?? 0)
                ]));

                if (empty($range)) {
                    return null;
                }

                sort($range);

                return 'Reps: ' . implode('–', $range);
            }
        );
    }
}
