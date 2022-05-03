<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Journey;

use App\Helpers\ViewHelper;
use App\Models\Journey;
use App\Models\Trip;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class JourneyItemScreen extends Screen
{
    /**
     * @var Journey
     */
    public Journey $journey;

    /**
     * Query data.
     *
     * @param Journey $journey
     *
     * @return array
     */
    public function query(Journey $journey): iterable
    {
        $fuelReplenishment = 0;
        $mileage = 0;

        $trips = $journey->trips->sortBy('start_time');

        foreach ($trips as $trip) {
            $mileage += $trip->mileage;
            $fuelReplenishment += $trip->fuel_refill;
        }

        $startFuel = $trips->first()->fuel_remains;
        $finishFuel = $trips->last()->fuel_remains;

        if (!$startFuel || !$finishFuel) {
            Toast::warning('To calculate fuel consumption please fill fuel remains for first and last trips');
        }

        $fuelUsed = $startFuel && $finishFuel ? $startFuel - $finishFuel + $fuelReplenishment : null;

        return [
            'journey'                    => $journey->load(['trips', 'trips.client', 'trips.employee', 'trips.truck', 'trips.localityFrom', 'trips.localityTo']),
            'journey.trips'              => $trips,
            'metrics.fuel_replenishment' => $fuelReplenishment,
            'metrics.fuel_used'          => $fuelUsed,
            'metrics.fuel_consumption'   => number_format($fuelUsed / $mileage * 100, 2) . ' l/km',
            'metrics.mileage'            => $mileage,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->journey->name;
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Journey: ' . $this->journey->name;
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.journeys.see',
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->journey->exists),

        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::table('journey.trips', [

                TD::make('trip_id', 'ID')
                    ->render(function (Trip $trip) {
                        return '<a href="' . route('platform.trips.edit', $trip->id) . '">' . $trip->id . '</a>';
                    }),

                TD::make('client_id', 'Client')
                    ->render(function (Trip $trip) {
                        return $trip->client->name;
                    }),

                TD::make('employee_id', 'Client')
                    ->render(function (Trip $trip) {
                        return $trip->employee->name;
                    }),

                TD::make('truck_id', 'Truck')
                    ->render(function (Trip $trip) {
                        return ViewHelper::formatTruckName($trip->truck);
                    }),

                TD::make('locality_from_id', 'Locality From')
                    ->render(function (Trip $trip) {
                        return $trip->localityFrom->name;
                    }),

                TD::make('locality_to_id', 'Locality To')
                    ->render(function (Trip $trip) {
                        return $trip->localityTo->name;
                    }),

                TD::make('status', 'Status')
                    ->render(function (Trip $trip) {
                        return match ($trip->status) {
                            Trip::STATUS_ORDERED => '<span class="text-primary">ordered</span>',
                            Trip::STATUS_DONE => '<span class="text-success">done</span>',
                            Trip::STATUS_IN_PROGRESS => '<span class="text-warning">in progress</span>',
                        };
                    }),

                TD::make('mileage', 'Mileage')
                    ->render(function (Trip $trip) {
                        return $trip->mileage;
                    }),

                TD::make('fuel_remains', 'Fuel Remains')
                    ->render(function (Trip $trip) {
                        return $trip->fuel_remains;
                    }),

                TD::make('fuel_refill', 'Fuel Refill')
                    ->render(function (Trip $trip) {
                        return $trip->fuel_refill;
                    }),

                TD::make('start_time', 'Start time')
                    ->render(function (Trip $trip) {
                        return $trip->start_time;
                    }),

                TD::make('finish_time', 'Finish time')
                    ->render(function (Trip $trip) {
                        return $trip->finish_time;
                    }),
            ]),

            Layout::metrics([
                'Fuel Replenishment' => 'metrics.fuel_replenishment',
                'Fuel Used'          => 'metrics.fuel_used',
                'Total Mileage'      => 'metrics.mileage',
                'Fuel Consumption'   => 'metrics.fuel_consumption',
            ]),
        ];
    }
}
