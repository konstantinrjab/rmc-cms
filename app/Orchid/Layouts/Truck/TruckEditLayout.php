<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Truck;

use App\Helpers\ViewHelper;
use App\Models\Employee;
use App\Models\Truck;
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
        $employeesOptions = Employee::all()->keyBy('id')->map(fn($e) => $e->name)->toArray();

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

            Select::make('truck.status')
                ->required()
                ->empty(__('No select'))
                ->options(ViewHelper::selectOptions([Truck::STATUS_OK, Truck::STATUS_ON_THE_WAY, Truck::STATUS_UNDER_REPAIR]))
                ->title(__('Status'))
                ->placeholder(__('Status')),

            Select::make('truck.employee_id')
                ->options($employeesOptions)
                ->empty()
                ->title(__('Employee')),

        ];
    }
}
