<?php

namespace App\Orchid\Layouts\Truck;

use App\Models\Truck;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TruckListLayout extends Table
{
    protected $title = 'Trucks';

    protected $target = 'trucks';

    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->cantHide()
                ->filter(Input::make())
                ->render(function (Truck $truck) {
                    return $truck->name;
                }),

            TD::make('number', __('Number'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Truck $truck) {
                    return $truck->number;
                }),

            TD::make('employee_id', __('Employee'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Truck $truck) {
                    return $truck->employee?->name;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Truck $truck) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.trucks.edit', $truck->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $truck->id,
                                ]),
                        ]);
                }),
        ];
    }
}
