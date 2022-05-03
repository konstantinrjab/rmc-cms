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
        $clients = Client::all()->keyBy('id')->pluck('name')->toArray();
        $employees = Employee::all()->keyBy('id')->pluck('name')->toArray();
        $trucks = Truck::all()->keyBy('id')->pluck('name')->toArray();

        $localities = [];

        foreach (Locality::all()->keyBy('id') as $id => $locality) {
            $localities[$id] = ViewHelper::formatLocality($locality);
        }

        return [

//            'client_id',
//            'employee_id',
//            'truck_id',
//            'locality_from_id',
//            'locality_to_id',
//            'status',
//            'mileage',
//            'fuel_remains',
//            'fuel_refill',
//            'start_time',
//            'finish_time',

            Select::make('trip.client_id')
                ->required()
                ->options($clients)
                ->title(__('Client'))
                ->placeholder(__('Client')),

            Select::make('trip.employee_id')
                ->required()
                ->options($employees)
                ->title(__('Employee'))
                ->placeholder(__('Employee')),

            Select::make('trip.truck_id')
                ->required()
                ->options($trucks)
                ->title(__('Trucks'))
                ->placeholder(__('Trucks')),

            Select::make('trip.locality_from_id')
                ->required()
                ->options($localities)
                ->title(__('Locality From'))
                ->placeholder(__('Locality From')),

            Select::make('trip.locality_from_to')
                ->required()
                ->options($localities)
                ->title(__('Locality To'))
                ->placeholder(__('Locality To')),

            Select::make('trip.status')
                ->required()
                ->options(ViewHelper::selectOptions([Trip::STATUS_ORDERED, Trip::STATUS_IN_PROGRESS, Trip::STATUS_DONE]))
                ->title(__('Status'))
                ->placeholder(__('Status')),

//            Input::make('trip.position')
//                ->type('text')
//                ->title(__('Position'))
//                ->placeholder(__('Position')),
        ];
    }
}
