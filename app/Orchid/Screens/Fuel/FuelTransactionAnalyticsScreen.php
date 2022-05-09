<?php

namespace App\Orchid\Screens\Fuel;

use App\Helpers\ViewHelper;
use App\Models\FuelTransaction;
use App\Models\Truck;
use App\Orchid\Layouts\Fuel\FuelConsumptionChart;
use Illuminate\Support\Collection;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class FuelTransactionAnalyticsScreen extends Screen
{
    public function query(): iterable
    {
        $data = [];
        $transactions = FuelTransaction::with(['operator', 'truck'])->get();
        /** @var Collection $byTrucks */
        $byTrucks = $transactions->filter(fn($e) => $e->truck_id)->groupBy('truck_id');

        foreach ($byTrucks as $byTruck) {

            $data[ViewHelper::formatTruckName($byTruck->first()->truck)] = $byTruck->sum(fn($e) => $e->quantity);
        }
        $data['Other'] = $transactions->filter(fn($e) => empty($e->truck_id))->sum(fn($e) => $e->quantity);

        $consumption = $transactions->filter(fn($transaction) => $transaction->transaction_type == FuelTransaction::TYPE_EXPENSE);
        $replenishment = $transactions->filter(fn($transaction) => $transaction->transaction_type == FuelTransaction::TYPE_INCOME);

        return [
            'fuelTransactions' => [
                [
                    'name'   => 'Consumption',
                    'values' => array_values($data),
                    'labels' => array_keys($data),
                ]
            ],
            'trucks'           => Truck::with(['fuelTransactions', 'trips'])->get(),
            'metrics'          => [
                'consumption'   => ['value' => number_format($consumption->pluck('quantity')->sum())],
                'replenishment' => ['value' => number_format($replenishment->pluck('quantity')->sum())],
            ],
        ];
    }

    public function name(): ?string
    {
        return __('Fuel Analytics');
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                FuelConsumptionChart::class,
            ]),

            Layout::metrics([
                'Overall Consumption'   => 'metrics.consumption',
                'Overall Replenishment' => 'metrics.replenishment',
            ]),

            Layout::table('trucks', [
                TD::make('name', __('Name'))
                    ->cantHide(),

                TD::make('employee', __('Employee'))
                    ->render(fn($e) => $e->employee->name)
                    ->cantHide(),

                TD::make('average_consumption', __('Average Consumption'))
                    ->render(function (Truck $truck) {
                        $consumption = $truck->fuelTransactions->isEmpty() ? 0 : $truck->fuelTransactions->sum(fn($e) => $e->quantity);
                        $distance = $truck->trips->isEmpty() ? 1 : $truck->trips->sum(fn($e) => $e->distance);

                        return ViewHelper::averageFuelConsumption($consumption, $distance);
                    })
                    ->cantHide(),
            ])
                ->title(__('Consumption by truck')),
        ];
    }
}
