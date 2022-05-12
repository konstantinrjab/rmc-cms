<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Fuel;

use App\Models\Employee;
use App\Models\FuelTransaction;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class FuelTransactionEditOwnStationLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $employees = Employee::all()->keyBy('id');
        $employeesOptions = $employees->map(fn($e) => $e->name);

        return [

            Input::make('fuelTransaction.quantity')
                ->type('number')
                ->required()
                ->title(__('Quantity')),

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
                ->hidden()
                ->value(FuelTransaction::TYPE_INCOME),

            Input::make('fuelTransaction.source_id')
                ->required()
                ->hidden()
                ->value(FuelTransaction::TYPE_SOURCE_TANK_FARM),

            Input::make('fuelTransaction.fuel_type')
                ->required()
                ->hidden()
                ->value(FuelTransaction::TYPE_FUEL_DIESEL),

            Input::make('fuelTransaction.consumer_type')
                ->required()
                ->hidden()
                ->value(FuelTransaction::TYPE_OWN_STATION),
        ];
    }
}
