<?php

namespace App\Helpers;

use App\Models\Locality;
use App\Models\Truck;

class ViewHelper
{
    public static function selectOptions(array $options): array
    {
        return array_combine($options, $options);
    }

    public static function formatTruckName(Truck $truck): string
    {
        return $truck->name . ': ' . $truck->number;
    }

    public static function formatLocality(Locality $locality): string
    {
        return $locality->name . ' (' . $locality->region . ', ' . $locality->district . ')';
    }
}
