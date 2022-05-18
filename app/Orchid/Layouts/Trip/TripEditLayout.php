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
                ->empty()
                ->options($employees)
                ->title(__('Employee'))
                ->placeholder(__('Employee')),

            Select::make('trip.truck_id')
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

            Select::make('trip.delivery_status')
                ->required()
                ->empty()
                ->options(ViewHelper::selectOptions([Trip::DELIVERY_STATUS_ORDERED, Trip::DELIVERY_STATUS_IN_PROGRESS, Trip::DELIVERY_STATUS_DONE]))
                ->title(__('Delivery Status')),

            Select::make('trip.payment_status')
                ->required()
                ->empty()
                ->options(ViewHelper::selectOptions([Trip::PAYMENT_STATUS_PAYED, Trip::PAYMENT_STATUS_NO_INVOICE, Trip::PAYMENT_STATUS_INVOICE_SENT, Trip::PAYMENT_STATUS_NOT_NEEDED]))
                ->title(__('Payment Status')),

            Input::make('trip.income')
                ->type('number')
                ->title(__('Income')),

            Input::make('trip.distance')
                ->type('number')
                ->title(__('Distance')),

            Input::make('trip.fuel_remains')
                ->type('number')
                ->title(__('Fuel Remains')),

            DateTimer::make('trip.start_time')
                ->format24hr()
                ->enableTime()
                ->title('Start Time'),

            DateTimer::make('trip.finish_time')
                ->format24hr()
                ->enableTime()
                ->title('Finish Time'),
        ];
    }
}
