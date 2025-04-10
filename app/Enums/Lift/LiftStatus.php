<?php

namespace App\Enums\Lift;

enum LiftStatus: string
{
    case NotStarted = 'not_started';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Skipped = 'skipped';

    public function label(): string
    {
        return match ($this) {
            self::NotStarted => 'Not Started',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Skipped => 'Skipped',
        };
    }

    public static function orderBy(): string
    {
        $order = implode(
            "', '",
            array_map(fn ($case) => $case->value, self::cases())
        );

        return "FIELD(status, '$order')";
    }
}
