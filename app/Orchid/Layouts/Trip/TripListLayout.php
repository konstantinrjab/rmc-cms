<?php

namespace App\Orchid\Layouts\Trip;

use App\Helpers\ViewHelper;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Trip;
use App\Models\Truck;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class TripListLayout extends Table
{
    protected $title = 'Trips';

    protected $target = 'trips';

    public function columns(): array
    {
        $clients = Client::all();
        $employees = Employee::all();
        $trucks = Truck::all();

        return [
            TD::make('client_id', __('Client'))
                ->sort()
                ->filter(TD::FILTER_SELECT, $clients->keyBy('id')->pluck('name'))
                ->render(function (Trip $trip) {
                    return $trip->client->name;
                }),

            TD::make('employee_id', __('Employee'))
                ->sort()
                ->cantHide()
                ->filter(TD::FILTER_SELECT, $employees->keyBy('id')->pluck('name'))
                ->render(function (Trip $trip) {
                    return $trip->employee->name;
                }),

            TD::make('truck_id', __('Truck'))
                ->sort()
                ->filter(TD::FILTER_SELECT, $trucks->keyBy('id')->map(function (Truck $truck) {
                    return ViewHelper::formatTruckName($truck);
                }))
                ->render(function (Trip $trip) {
                    return ViewHelper::formatTruckName($trip->truck);
                }),

            TD::make('locality_from_id', __('Locality From'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->localityFrom->name;
                }),

            TD::make('locality_to_id', __('Locality To'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->localityTo->name;
                }),

            TD::make('status', __('Status'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return match($trip->status) {
                        TripStatus::ORDERED->name => '<span class="text-primary">ordered</span>',
                        TripStatus::DONE->name => '<span class="text-success">done</span>',
                        TripStatus::IN_PROGRESS->name=> '<span class="text-warning">in progress</span>',
                    };
                }),

            TD::make('mileage', __('Mileage'))
                ->sort()
                ->defaultHidden()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->mileage;
                }),

            TD::make('fuel_remains', __('Fuel Remains'))
                ->sort()
                ->defaultHidden()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->fuel_remains;
                }),

            TD::make('fuel_refill', __('Fuel Refill'))
                ->sort()
                ->defaultHidden()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->fuel_refill;
                }),

            TD::make('start_time', __('Start Time'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->start_time;
                }),

            TD::make('finish_time', __('Finish Time'))
                ->sort()
                ->defaultHidden()
                ->filter(Input::make())
                ->render(function (Trip $trip) {
                    return $trip->finish_time;
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Trip $trip) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.trips.edit', $trip->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $trip->id,
                                ]),
                        ]);
                }),
        ];
    }
}
