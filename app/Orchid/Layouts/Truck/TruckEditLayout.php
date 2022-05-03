<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Truck;

use App\Models\Employee;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class TruckEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $employeesOptions = Employee::all()->keyBy('id')->pluck('name');

        return [
            Input::make('truck.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('truck.number')
                ->type('text')
                ->max(10)
                ->required()
                ->title(__('Number'))
                ->placeholder(__('Number')),

            Select::make('truck.employee_id')
                ->required()
                ->options($employeesOptions)
                ->empty()
                ->title('Select employee'),

        ];
    }
}
