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

class FuelTransactionEditLayout extends Rows
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
            Select::make('fuelTransaction.transaction_type')
                ->required()
                ->options([
                    FuelTransaction::TYPE_INCOME  => __(FuelTransaction::TYPE_INCOME),
                    FuelTransaction::TYPE_EXPENSE => __(FuelTransaction::TYPE_EXPENSE),
                ])
                ->empty()
                ->title('Select transaction type'),

            Select::make('fuelTransaction.fuel_type')
                ->required()
                ->options([
                    'diesel' => 'Diesel',
                ])
                ->hidden()
                ->title('Select fuel type'),

            Input::make('fuelTransaction.quantity')
                ->type('number')
                ->required()
                ->title(__('Quantity')),

            Select::make('fuelTransaction.operator_id')
                ->options($employeesOptions)
                ->required()
                ->empty()
                ->title('Select operator')
                ->help('A person who performs transaction'),

            Select::make('fuelTransaction.subject_id')
                ->options($employeesOptions)
                ->empty()
                ->title('Select subject')
                ->help('Transaction subject'),

            DateTimer::make('fuelTransaction.datetime')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title('Select transaction date')
                ->help('Transaction date'),

        ];
    }
}
