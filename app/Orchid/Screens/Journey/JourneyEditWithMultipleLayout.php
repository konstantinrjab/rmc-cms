<?php

namespace App\Orchid\Screens\Journey;

use App\Helpers\ViewHelper;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Truck;
use App\View\Fields\MultipleInput;
use App\View\Fields\MultipleInputLayout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;

class JourneyEditWithMultipleLayout extends MultipleInputLayout
{
    public function attributes(): array
    {
        $employees = Employee::all()->keyBy('id')->map(fn($e) => $e->name);
        $clients = Client::all()->keyBy('id')->map(fn($e) => $e->name)->toArray();
        $employees = Employee::all()->keyBy('id')->map(fn($e) => $e->name)->toArray();
        $trucks = Truck::all()->keyBy('id')->map(fn($e) => ViewHelper::formatTruckName($e))->toArray();

        return [
            MultipleInput::make('journey.trips[]')
                ->properties(['id', 'start_time'])
                ->renderers([
                    Input::make('id')
                        ->required()
                        ->title(__('ID'))
                        ->placeholder(__('ID')),

                    Select::make('employee_id')
                        ->required()
                        ->options($employees)
                        ->title(__('Employee'))
                        ->placeholder(__('Employee')),

                    Select::make('client_id')
                        ->required()
                        ->options($clients)
                        ->title(__('Client'))
                        ->placeholder(__('Client')),
                ])
                ->placeholder(__('ID')),
        ];
    }
}
