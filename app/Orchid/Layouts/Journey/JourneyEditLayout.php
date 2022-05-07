<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Journey;

use App\Models\Employee;
use App\View\Fields\MultipleInput;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
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
                ->title(__('Date From'))
                ->help(__('Date From')),

            DateTimer::make('journey.date_to')
                ->required()
                ->format24hr()
                ->enableTime()
                ->title(__('Date To'))
                ->help(__('Date To')),

            Quill::make('journey.comment')
                ->title('Comment'),

            MultipleInput::make('journey.transactions')
                ->renderers([
                    Input::make('amount')
                        ->type('number')
                        ->required()
                        ->title(__('Amount')),

                    Input::make('name')
                        ->required()
                        ->title(__('Name')),

                    Input::make('comment')
                        ->title(__('Comment')),

                ])
                ->title(__('Transactions'))
        ];
    }
}
