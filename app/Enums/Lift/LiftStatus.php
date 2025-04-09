<?php

namespace App\Enums\Lift;

enum LiftStatus: string
{
    case NOT_STARTED = 'not_started';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case SKIPPED = 'skipped';

    public function label(): string
    {
        return match ($this) {
            self::NOT_STARTED => 'Not Started',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::SKIPPED => 'Skipped',
        };
    }

    public static function orderBy(): string
    {
        $order = implode("', '", array_map(fn($case) => $case->value, self::cases()));

        return "FIELD(status, '$order')";
    }
}
