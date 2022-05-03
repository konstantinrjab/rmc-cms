<?php

namespace App\Orchid\Layouts\Employee;

use App\Helpers\ViewHelper;
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

            TD::make('status', __('Status'))
                ->sort()
                ->filter(TD::FILTER_SELECT, ViewHelper::selectOptions([Employee::STATUS_OK, Employee::STATUS_ILL, Employee::STATUS_FIRED]))
                ->render(function (Employee $employee) {
                    return match($employee->status) {
                        Employee::STATUS_OK => '<span class="text-success">ok</span>',
                        Employee::STATUS_ILL => '<span class="text-danger">ill</span>',
                        Employee::STATUS_FIRED => '<span class="text-secondary">fired</span>',
                    };
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
