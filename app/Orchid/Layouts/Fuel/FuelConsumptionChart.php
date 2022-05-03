<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Fuel;

use Orchid\Screen\Layouts\Chart;

class FuelConsumptionChart extends Chart
{
    /**
     * @var string
     */
    protected $title = 'Fuel Consumption';

    /**
     * @var int
     */
    protected $height = 350;

    /**
     * Available options:
     * 'bar', 'line',
     * 'pie', 'percentage'.
     *
     * @var string
     */
    protected $type = 'pie';

    /**
     * @var string
     */
    protected $target = 'fuelTransactions';
}
