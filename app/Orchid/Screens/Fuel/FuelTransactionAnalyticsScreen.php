<?php

namespace App\Orchid\Screens\Fuel;

use App\Helpers\ViewHelper;
use App\Models\FuelTransaction;
use App\Models\Trip;
use App\Models\Truck;
use App\Orchid\Layouts\Fuel\FuelConsumptionChart;
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
        $data = [];
        $transactions = FuelTransaction::with(['operator', 'truck']);

        if ($dateFrom = request('date_from')) {
            $transactions->where('datetime', '>=', $dateFrom);
        }
        if ($dateTo = request('date_to')) {
            $transactions->where('datetime', '<=', $dateTo);
        }

        $transactions = $transactions->get();
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

            Layout::columns([
                FuelConsumptionChart::class,
            ]),

            Layout::metrics([
                'Overall Consumption'   => 'metrics.consumption',
                'Overall Replenishment' => 'metrics.replenishment',
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
        ];
    }
}
