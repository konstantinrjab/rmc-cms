<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Fuel;

use App\Helpers\ViewHelper;
use App\Models\Employee;
use App\Models\FuelTransaction;
use App\Models\Truck;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class FuelTransactionEditVehicleLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $trucks = Truck::all()->keyBy('id');
        $employees = Employee::all()->keyBy('id');
        $employeesOptions = $employees->map(fn($e) => $e->name);
        $trucksOptions = $trucks->map(fn($e) => ViewHelper::formatTruckName($e));

        return [

            Input::make('fuelTransaction.quantity')
                ->type('number')
                ->required()
                ->title(__('Quantity')),

            Select::make('fuelTransaction.source_id')
                ->options(FuelTransaction::getSources([FuelTransaction::TYPE_SOURCE_OWN_STATION, FuelTransaction::TYPE_SOURCE_AMIC]))
                ->required()
                ->empty()
                ->title('Source'),

            Select::make('fuelTransaction.consumer_type')
                ->required()
                ->options(ViewHelper::selectOptions([FuelTransaction::TYPE_TRUCK, FuelTransaction::TYPE_OTHER]))
                ->empty()
                ->title('Consumer Type'),

            Select::make('fuelTransaction.truck_id')
                ->options($trucksOptions)
                ->empty()
                ->title('Consumer'),

            Input::make('fuelTransaction.price')
                ->type('number')
                ->title('Price per liter'),

            Select::make('fuelTransaction.operator_id')
                ->options($employeesOptions)
                ->required()
                ->empty()
                ->title('Operator')
                ->help('A person who performs transaction'),

            Input::make('fuelTransaction.comment')
                ->max(255)
                ->title(__('Comment'))
                ->placeholder(__('Comment')),

            DateTimer::make('fuelTransaction.datetime')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title('Date')
                ->help('Transaction date'),


            Input::make('fuelTransaction.transaction_type')
                ->required()
                ->value(FuelTransaction::TYPE_EXPENSE)
                ->hidden(),

            Input::make('fuelTransaction.fuel_type')
                ->required()
                ->hidden()
                ->value(FuelTransaction::TYPE_FUEL_DIESEL),
        ];
    }
}
