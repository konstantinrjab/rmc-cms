<?php

namespace App\Orchid\Screens\Fuel;

use App\Helpers\ViewHelper;
use App\Models\FuelTransaction;
use App\Models\Trip;
use App\Models\Truck;
use App\Orchid\Layouts\Fuel\FuelConsumptionChart;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class FuelTransactionAnalyticsScreen extends Screen
{
    public function query(): iterable
    {
        $transactions = FuelTransaction::with(['operator', 'truck']);

        $dateFrom = request()->has('date_from') ? request('date_from') : Carbon::now()->subDays(7)->format('Y-m-d');

        if ($dateFrom) {
            $transactions->where('datetime', '>=', $dateFrom);
        }
        if ($dateTo = request('date_to')) {
            $transactions->where('datetime', '<=', $dateTo);
        }

        $transactions = $transactions->get();
        /** @var Collection $byTrucks */
        $byTrucks = $transactions->filter(fn($e) => $e->truck_id)->groupBy('truck_id');

        $consumptionByTruck = [];

        foreach ($byTrucks as $grouped) {

            $consumptionByTruck[ViewHelper::formatTruckName($grouped->first()->truck)] = $grouped->sum(fn($e) => $e->quantity);
        }
        $consumptionByTruck['Other'] = $transactions->filter(fn($e) => empty($e->truck_id) && $e->consumer_type != FuelTransaction::TYPE_OWN_STATION)->sum(fn($e) => $e->quantity);

        $consumption = $transactions->filter(fn($transaction) => $transaction->transaction_type == FuelTransaction::TYPE_EXPENSE);
        $replenishment = $transactions->filter(fn($transaction) => $transaction->transaction_type == FuelTransaction::TYPE_INCOME);

        $truckConsumptionOwnStation = $consumption
            ->filter(fn($e) => $e->source_id == FuelTransaction::TYPE_SOURCE_OWN_STATION && $e->truck_id)
            ->pluck('quantity')
            ->sum();
        $truckConsumptionNotOwnStation = $consumption
            ->filter(fn($e) => $e->source_id != FuelTransaction::TYPE_SOURCE_OWN_STATION && $e->truck_id)
            ->pluck('quantity')
            ->sum();

        return [
            'fuelTransactions' => [
                [
                    'name'   => 'Consumption',
                    'values' => array_values($consumptionByTruck),
                    'labels' => array_keys($consumptionByTruck),
                ]
            ],
            'trucks'           => Truck::with(['fuelTransactions', 'trips'])->get(),
            'metrics'          => [
                'overall' => [
                    'consumption'   => ['value' => number_format($consumption->pluck('quantity')->sum())],
                    'replenishment' => ['value' => number_format($replenishment->pluck('quantity')->sum())],
                ],
                'truck'   => [
                    'consumption_own_station'     => ['value' => number_format($truckConsumptionOwnStation)],
                    'consumption_other' => ['value' => number_format($truckConsumptionNotOwnStation)],
                ],

                'own_station' => [
                    'consumption_trucks'     => ['value' => number_format($consumption->filter(fn($e) => $e->source_id == FuelTransaction::TYPE_SOURCE_OWN_STATION)->pluck('quantity')->sum())],
                    'consumption_not_trucks' => ['value' => number_format($consumption->filter(fn($e) => $e->source_id == FuelTransaction::TYPE_SOURCE_OWN_STATION && !$e->truck_id)->pluck('quantity')->sum())],
                    'replenishment'          => ['value' => number_format($replenishment->filter(fn($e) => $e->source_id == FuelTransaction::TYPE_SOURCE_OWN_STATION)->pluck('quantity')->sum())],
                ],
            ],
            'date_from'        => $dateFrom,
            'date_to'          => $dateTo,
        ];
    }

    public function name(): ?string
    {
        return __('Fuel Analytics');
    }

    public function layout(): iterable
    {
        return [
            Layout::rows([
                Group::make([

                    DateTimer::make('date_from')
                        ->format('Y-m-d')
                        ->required()
                        ->title('Date From'),

                    DateTimer::make('date_to')
                        ->format('Y-m-d')
                        ->required()
                        ->title('Date To'),

                ]),

                Button::make(__('Apply'))
                    ->icon('check')->type(Color::DEFAULT())
                    ->set('formmethod', 'get'),

            ]),

            Layout::tabs([

                __('Trucks') => [

                    Layout::metrics([
                        'Consumption: Own Station' => 'metrics.truck.consumption_own_station',
                        'Consumption: Other'       => 'metrics.truck.consumption_other',
                    ]),

                    Layout::columns([
                        FuelConsumptionChart::class,
                    ]),

                    Layout::table('trucks', [
                        TD::make('name', __('Name'))
                            ->render(fn($e) => ViewHelper::formatTruckName($e))
                            ->cantHide(),

                        TD::make('employee', __('Employee'))
                            ->render(fn($e) => $e?->employee->name)
                            ->cantHide(),

                        TD::make('average_consumption', __('Average Consumption'))
                            ->render(function (Truck $truck) {
                                $consumption = $truck->fuelTransactions->isEmpty() ? 0 : $truck->fuelTransactions->sum(fn($e) => $e->quantity);

                                $firstTrip = Trip::where(['truck_id' => $truck->id])->orderBy('start_time')->first();

                                $warning = null;
                                if (!$firstTrip) {
                                    $warning = '<span class="text-info">' . __('No trips found') . '</span>';
                                } elseif ($firstTrip->fuel_remains) {
                                    $consumption -= $firstTrip->fuel_remains;
                                } else {
                                    $warning = '<a href="' . route('platform.trips.edit', $firstTrip->id) . '" class="text-right"><span class="text-info">' . __('Add fuel remains to the first trip') . '</span></a>';
                                }

                                $distance = $truck->trips->isEmpty() ? 0 : $truck->trips->sum(fn($e) => $e->distance);

                                return '<span class="text-left">' . ViewHelper::averageFuelConsumption($consumption, $distance) . '</span>' . ($warning ? ' ' . $warning : '');
                            })
                            ->cantHide(),
                    ])
                        ->title(__('Consumption by truck')),
                ],

                __('Overall') => [

                    Layout::metrics([
                        'Overall Consumption'   => 'metrics.overall.consumption',
                        'Overall Replenishment' => 'metrics.overall.replenishment',
                    ]),

                    Layout::metrics([
                        'Trucks Consumption'     => 'metrics.own_station.consumption_trucks',
                        'Not Trucks Consumption' => 'metrics.own_station.consumption_not_trucks',
                        'Overall Replenishment'  => 'metrics.own_station.replenishment',
                    ])->title('Own Station'),
                ],

            ])
        ];
    }
}
