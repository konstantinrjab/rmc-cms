<?php

namespace App\Orchid\Layouts\Journey;

use App\Helpers\ViewHelper;
use App\Models\Journey;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class JourneyListLayout extends Table
{
    protected $title = 'Journeys';

    protected $target = 'journeys';

    public function columns(): array
    {
        return [
            TD::make('id', __('Id'))
                ->sort()
                ->render(function (Journey $journey) {
                    return '<a href="' . route('platform.journeys.item', $journey->id) . '"><span class="fw-bolder">' . $journey->id . '</span></a>';
                }),

            TD::make('employee_id', __('Employee'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Journey $journey) {
                    return $journey->employee->name;
                }),

            TD::make('date_from', __('Date From'))
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE)
                ->render(function (Journey $journey) {
                    return $journey->date_from->format('Y-m-d H:i');
                }),

            TD::make('date_to', __('Date To'))
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE)
                ->render(function (Journey $journey) {
                    return $journey->date_to->format('Y-m-d H:i');
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Journey $journey) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.journeys.edit', $journey->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $journey->id,
                                ]),
                        ]);
                }),
        ];
    }
}
