<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Employee;

use App\Helpers\ViewHelper;
use App\Models\Employee;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class EmployeeEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('employee.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('employee.position')
                ->type('text')
                ->title(__('Position'))
                ->placeholder(__('Position')),

            Select::make('employee.status')
                ->options(ViewHelper::selectOptions([Employee::STATUS_OK, Employee::STATUS_ILL, Employee::STATUS_FIRED]))
                ->required()
                ->title(__('Status'))
                ->placeholder(__('Status')),
        ];
    }
}
