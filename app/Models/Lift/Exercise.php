<?php

namespace App\Models\Lift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Exercise extends Model
{
    protected $table = 'lift_exercises';

    protected $casts = [
        'id' => 'integer',
    ];

    protected $fillable = [
        'video_url',
    ];

    protected function videoUrl(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) {
                    return null;
                }

                if (preg_match('/^https?:\/\//', $value)) {
                    return $value;
                }

                return 'https://' . $value;
            }
        );
    }
}
