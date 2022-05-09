<?php

namespace App\Orchid\Layouts\Journey;

use App\Helpers\ViewHelper;
use App\Models\Trip;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class JourneyItemLayout extends Table
{
    protected $title = 'Journeys';

    protected $target = 'journey.trips';

    public function columns(): array
    {
        return [

            TD::make('id', __('ID'))
                ->render(function (Trip $trip) {
                    return '<a href="' . route('platform.trips.edit', $trip->id) . '">' . $trip->id . '</a>';
                }),

            TD::make('client_id', __('Client'))
                ->render(function (Trip $trip) {
                    return $trip->client->name;
                }),

            TD::make('employee_id', __('Client'))
                ->render(function (Trip $trip) {
                    return $trip->employee->name;
                }),

            TD::make('truck_id', __('Truck'))
                ->render(function (Trip $trip) {
                    return ViewHelper::formatTruckName($trip->truck);
                }),

            TD::make('locality_from_id', __('Locality From'))
                ->render(function (Trip $trip) {
                    return $trip->localityFrom->name;
                }),

            TD::make('locality_to_id', __('Locality To'))
                ->render(function (Trip $trip) {
                    return $trip->localityTo->name;
                }),

            TD::make('delivery_status', __('Delivery Status'))
                ->render(function (Trip $trip) {
                    return match ($trip->delivery_status) {
                        Trip::DELIVERY_STATUS_ORDERED => '<span class="text-primary">' . __(Trip::DELIVERY_STATUS_ORDERED) . '</span>',
                        Trip::DELIVERY_STATUS_DONE => '<span class="text-success">' . __(Trip::DELIVERY_STATUS_DONE) . '</span>',
                        Trip::DELIVERY_STATUS_IN_PROGRESS => '<span class="text-warning">' . __(Trip::DELIVERY_STATUS_IN_PROGRESS) . '</span>',
                    };
                }),

            TD::make('distance', __('Distance'))
                ->render(function (Trip $trip) {
                    return $trip->distance;
                }),

            TD::make('fuel_remains', __('Fuel Remains'))
                ->render(function (Trip $trip) {
                    return $trip->fuel_remains;
                }),

            TD::make('start_time', __('Start Time'))
                ->render(function (Trip $trip) {
                    return $trip->start_time;
                }),

            TD::make('finish_time', __('Finish Time'))
                ->render(function (Trip $trip) {
                    return $trip->finish_time;
                }),
        ];
    }
}
