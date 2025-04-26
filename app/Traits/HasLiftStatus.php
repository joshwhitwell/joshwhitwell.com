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
}
