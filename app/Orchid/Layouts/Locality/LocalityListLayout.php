<?php

namespace App\Orchid\Layouts\Locality;

use App\Models\Locality;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LocalityListLayout extends Table
{
    protected $title = 'Localities';

    protected $target = 'localities';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Locality $locality) {
                    return $locality->name;
                }),

            TD::make('region', __('Region'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Locality $locality) {
                    return $locality->region;
                }),

            TD::make('district', __('District'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Locality $locality) {
                    return $locality->district;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Locality $locality) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.localities.edit', $locality->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $locality->id,
                                ]),
                        ]);
                }),
        ];
    }
}
