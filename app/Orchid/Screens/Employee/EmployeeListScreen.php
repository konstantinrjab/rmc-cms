<?php

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use App\Orchid\Layouts\Employee\EmployeeListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'employees' => Employee::filters()->defaultSort('name')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Employees');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.employees.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                EmployeeListLayout::class,
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        Employee::findOrFail($request->get('id'))->delete();

        Toast::info(__('Employee was removed'));
    }
}
