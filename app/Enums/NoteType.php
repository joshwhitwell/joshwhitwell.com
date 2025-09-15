<?php

namespace App\Enums;

enum NoteType: string
{
    case Idea = 'idea';
    case Quote = 'quote';
    case ReadingList = 'readinglist';
    case Todo = 'todo';
    case Wishlist = 'wishlist';

    public function label(): string
    {
        return match($this) {
            self::Idea => 'Idea',
            self::Quote => 'Quote',
            self::ReadingList => 'Reading List',
            self::Todo => 'Todo',
            self::Wishlist => 'Wish List',
        };
    }

    public static function selectOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[] = [
                'value' => $case->value,
                'label' => $case->label(),
            ];
        }

        usort($options, function ($a, $b) {
            return $a['label'] <=> $b['label'];
        });

        return $options;
    }
}
