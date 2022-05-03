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
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Journey $journey) {
                    return '<a href="' . route('platform.journeys.item', $journey->id) . '">' . ViewHelper::formatJourneyName($journey) . '</a>';
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
