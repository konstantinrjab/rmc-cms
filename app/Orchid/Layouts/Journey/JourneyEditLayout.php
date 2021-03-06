<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Journey;

use App\Models\Employee;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class JourneyEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $employees = Employee::all()->keyBy('id')->map(fn($e) => $e->name)->toArray();

        return [
            Select::make('journey.employee_id')
                ->required()
                ->empty()
                ->options($employees)
                ->title(__('Employee'))
                ->placeholder(__('Employee')),

            DateTimer::make('journey.date_from')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title(__('Date From')),

            DateTimer::make('journey.date_to')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title(__('Date To')),

            Quill::make('journey.comment')
                ->title('Comment'),

            Matrix::make('journey.transactions')
                ->title('Journey Transactions')
                ->columns(['name', 'amount', 'comment'])
                ->fields([
                    'name'   => Input::make()
                        ->required(),
                    'amount'   => Input::make()
                        ->type('number')
                        ->required(),
                    'comment'   => Input::make(),
                ]),
        ];
    }
}
