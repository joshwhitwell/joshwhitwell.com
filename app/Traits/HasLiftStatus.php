<?php

namespace App\Traits;

use App\Enums\Lift\LiftStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasLiftStatus
{
    protected function notStarted(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === LiftStatus::NotStarted
        );
    }

    protected function inProgress(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === LiftStatus::InProgress
        );
    }

    protected function completed(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === LiftStatus::Completed
        );
    }

    protected function skipped(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status === LiftStatus::Skipped
        );
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                $attributes = ['status' => $value];

                if ($value === LiftStatus::InProgress->value && !$this->started_at) {
                    $attributes['started_at'] = now();
                }
                
                if (in_array($value, [LiftStatus::Completed->value, LiftStatus::Skipped->value])) {
                    $attributes['completed_at'] = now();
                }
                
                return $attributes;
            }
        );
    }
}
