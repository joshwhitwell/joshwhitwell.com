<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Writing extends Model
{
    protected $fillable = [
        'type',
        'title',
        'body',
        'visibility',
        'written_at',
    ];

    public static $types = [
        'journal' => 'Journal',
        'quote' => 'Quote',
    ];

    protected function internalTitle(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->title) {
                    return $this->title;
                } elseif ($this->id) {
                    return "#$this->id";
                } else {
                    return 'New Writing';
                }
            },
        );
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::make(
            get: function () {
                return static::$types[$this->type] ?? null;
            },
        );
    }
}
