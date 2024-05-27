<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Writing extends Model
{
    protected $fillable = [
        'title',
        'body',
        'visibility',
        'written_at',
    ];

    protected function internalTitle(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($this->title) {
                    return $this->title;
                } else if ($this->id) {
                    return 'Writing ' . $this->id;
                } else {
                    return 'New Writing';
                }
            },
        );
    }
}
