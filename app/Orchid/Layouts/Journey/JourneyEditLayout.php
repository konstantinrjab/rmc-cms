<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Journey;

use App\Helpers\ViewHelper;
use App\Models\Trip;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class JourneyEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $journey = $this->query->get('journey');

        $trips = Trip::orderBy('start_time')
            ->get()
            ->keyBy('id')
            ->map(function (Trip $trip) {
                return ViewHelper::formatTripName($trip);
            });

        $selectedTrips = $journey
            ? $journey->trips->keyBy('id')
                ->map(fn(Trip $trip) => ViewHelper::formatTripName($trip))
                ->keys()
                ->toArray()
            : [];

        return [
            Input::make('journey.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Select::make('journey.trip_ids')
                ->options($trips)
                ->value($selectedTrips)
                ->multiple()
                ->required()
                ->title(__('Trips'))
                ->placeholder(__('Trips')),
        ];
    }
}
