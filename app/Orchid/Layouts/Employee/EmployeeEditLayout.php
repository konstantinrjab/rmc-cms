<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Employee;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
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
        ];
    }
}
