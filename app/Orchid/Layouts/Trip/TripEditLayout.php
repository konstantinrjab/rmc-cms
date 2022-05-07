<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Trip;

use App\Helpers\ViewHelper;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Locality;
use App\Models\Trip;
use App\Models\Truck;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class TripEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $clients = Client::all()->keyBy('id')->map(fn($e) => $e->name)->toArray();
        $employees = Employee::all()->keyBy('id')->map(fn($e) => $e->name)->toArray();
        $trucks = Truck::all()->keyBy('id')->map(fn($e) => ViewHelper::formatTruckName($e))->toArray();

        $localities = [];

        foreach (Locality::all()->keyBy('id') as $id => $locality) {
            $localities[$id] = ViewHelper::formatLocality($locality);
        }

        return [

            Select::make('trip.client_id')
                ->required()
                ->empty()
                ->options($clients)
                ->title(__('Client'))
                ->placeholder(__('Client')),

            Select::make('trip.employee_id')
                ->required()
                ->empty()
                ->options($employees)
                ->title(__('Employee'))
                ->placeholder(__('Employee')),

            Select::make('trip.truck_id')
                ->required()
                ->empty()
                ->options($trucks)
                ->title(__('Trucks'))
                ->placeholder(__('Trucks')),

            Select::make('trip.locality_from_id')
                ->required()
                ->empty()
                ->options($localities)
                ->title(__('Locality From'))
                ->placeholder(__('Locality From')),

            Select::make('trip.locality_to_id')
                ->required()
                ->empty()
                ->options($localities)
                ->title(__('Locality To'))
                ->placeholder(__('Locality To')),

            Select::make('trip.status')
                ->required()
                ->empty()
                ->options(ViewHelper::selectOptions([Trip::STATUS_ORDERED, Trip::STATUS_IN_PROGRESS, Trip::STATUS_DONE]))
                ->title(__('Status'))
                ->placeholder(__('Status')),

            Input::make('trip.mileage')
                ->type('number')
                ->required()
                ->title(__('Mileage'))
                ->placeholder(__('Mileage')),

            Input::make('trip.fuel_remains')
                ->type('number')
                ->title(__('Fuel Remains'))
                ->placeholder(__('Fuel Remains')),

            Input::make('trip.fuel_refill')
                ->type('number')
                ->title(__('Fuel Refill'))
                ->placeholder(__('Fuel Refill')),

            DateTimer::make('trip.start_time')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title('Start Time')
                ->help('Start Time'),

            DateTimer::make('trip.finish_time')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title('Finish Time')
                ->help('Finish Time'),
        ];
    }
}
