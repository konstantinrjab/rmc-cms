<?php

namespace App\Helpers;

use App\Models\Locality;
use App\Models\Trip;
use App\Models\Truck;
use Illuminate\Support\Str;

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

    public static function formatTripName(Trip $trip): string
    {
        return Str::limit($trip->employee->name, 15, '') . ', '
            . $trip->localityFrom->name . '-'
            . $trip->localityTo->name . ', '
            . $trip->start_time->format('d.m.y');
    }

    public static function formatLocality(Locality $locality): string
    {
        $name = $locality->name . ' (' . $locality->region;

        return $locality->district ?  $name . ', ' . $locality->district . ')' :  $name . ')';
    }
}
