<?php

namespace App\Orchid\Layouts\Trip;

enum TripStatus
{
    case ORDERED;
    case IN_PROGRESS;
    case DONE;

    public static function values(): array
    {
        return array_column(self::cases(), 'name');
    }
}
