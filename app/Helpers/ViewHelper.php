<?php

namespace App\Helpers;

use App\Models\Truck;

class ViewHelper
{
    public static function formatTruckName(Truck $truck): string
    {
        return $truck->name . ': ' . $truck->number;
    }
}
