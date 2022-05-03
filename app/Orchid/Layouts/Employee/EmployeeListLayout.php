<?php

namespace App\Orchid\Layouts\Employee;

use App\Models\Employee;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EmployeeListLayout extends Table
{
    protected $title = 'Employees';

    protected $target = 'employees';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Employee $employee) {
                    return $employee->name;
                }),

            TD::make('position', __('Position'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Employee $employee) {
                    return $employee->position;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Employee $employee) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.employees.edit', $employee->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $employee->id,
                                ]),
                        ]);
                }),
        ];
    }
}
