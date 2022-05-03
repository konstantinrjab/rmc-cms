<?php

namespace App\Helpers;

use App\Models\Journey;
use App\Models\Locality;
use App\Models\Trip;
use App\Models\Truck;
use Illuminate\Support\Str;

class ViewHelper
{
    public static function selectOptions(array $options): array
    {
        return array_combine($options, array_map('__', $options));
    }

    public static function formatTruckName(Truck $truck): string
    {
        return $truck->name . ': ' . $truck->number;
    }

    public static function formatJourneyName(Journey $journey): string
    {
        return $journey->employee->name . ': ' . $journey->date_from->format('y.m.d');
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
        $name = $locality->name . ' (' . __($locality->region);

        return $locality->district ?  $name . ', ' . $locality->district . ')' :  $name . ')';
    }
}
