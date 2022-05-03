<?php

namespace App\Orchid\Screens\Fuel;

use App\Models\FuelTransaction;
use App\Orchid\Layouts\Fuel\FuelConsumptionChart;
use App\Orchid\Layouts\Fuel\FuelTransactionAnalyticsLayout;
use Illuminate\Support\Collection;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class FuelTransactionAnalyticsScreen extends Screen
{
    public function query(): iterable
    {
        $data = [];
        $transactions = FuelTransaction::with('subject')->get();
        /** @var Collection $transactionGroups */
        $transactionGroups = $transactions->groupBy('subject_id');

        foreach ($transactionGroups as $transactionGroup) {

            $data[$transactionGroup->first()->subject->name] = $transactionGroup->sum(function (FuelTransaction $transaction) {
                return $transaction->quantity;
            });
        }

        $consumption = $transactions->filter(fn($transaction) => $transaction->transaction_type == FuelTransaction::TYPE_SALE);
        $replenishment = $transactions->filter(fn($transaction) => $transaction->transaction_type == FuelTransaction::TYPE_PURCHASE);

        return [
            'fuelTransactions' => [
                [
                    'name'   => 'Consumption',
                    'values' => array_values($data),
                    'labels' => array_keys($data),
                ]
            ],
            'metrics'          => [
                'consumption'   => ['value' => number_format($consumption->pluck('quantity')->sum())],
                'replenishment' => ['value' => number_format($replenishment->pluck('quantity')->sum())],
                'orders'        => ['value' => number_format(10000), 'diff' => 23.4],
                'total'         => number_format(65661),
            ],
        ];
    }

    public function name(): ?string
    {
        return __('Fuel Transactions Analytics');
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
                'Pending Orders'        => 'metrics.orders',
                'Total Earnings'        => 'metrics.total',
            ]),
        ];
    }
}
