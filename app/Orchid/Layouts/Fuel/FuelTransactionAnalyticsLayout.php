<?php

namespace App\Orchid\Layouts\Fuel;

use Orchid\Support\Facades\Layout;
use Orchid\Screen\Layouts\Chart;

class FuelTransactionAnalyticsLayout extends Chart
{
    protected $title = 'Fuel Transactions';

    protected $target = 'fuelTransactions';

    public function columns(): array
    {
        return [
            Layout::columns([
                FuelConsumptionChart::class,
            ]),
        ];
    }
}
