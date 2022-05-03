<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Employee;

use App\Models\Employee;
use App\Orchid\Layouts\Employee\EmployeeEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class EmployeeEditScreen extends Screen
{
    /**
     * @var Employee
     */
    public Employee $employee;

    /**
     * Query data.
     *
     * @param Employee $employee
     *
     * @return array
     */
    public function query(Employee $employee): iterable
    {
        return [
            'employee' => $employee,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->employee->exists ? 'Edit Employee' : 'Create Employee';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Details such as name and position';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.employees',
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->employee->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(EmployeeEditLayout::class)
                ->title(__('Employee Information'))
                ->description(__('Update your employee information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->employee->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param Employee $employee
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Employee $employee, Request $request)
    {
        $employeeData = $request->get('employee');

        $employee
            ->fill($employeeData)
            ->save();

        Toast::info(__('Employee was saved.'));

        return redirect()->route('platform.employees');
    }

    /**
     * @param Employee $employee
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(Employee $employee)
    {
        $employee->delete();

        Toast::info(__('Employee was removed'));

        return redirect()->route('platform.employees');
    }
}
