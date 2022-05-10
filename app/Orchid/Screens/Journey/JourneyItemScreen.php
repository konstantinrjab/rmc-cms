<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Journey;

use App\Helpers\ViewHelper;
use App\Models\FuelTransaction;
use App\Models\Journey;
use App\Models\JourneyTransaction;
use App\Orchid\Layouts\Trip\TripListLayout;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class JourneyItemScreen extends Screen
{
    /**
     * @var Journey
     */
    public Journey $journey;

    /**
     * Query data.
     *
     * @param Journey $journey
     *
     * @return array
     */
    public function query(Journey $journey): iterable
    {
        $journey->load(['trips', 'trips.client', 'trips.employee', 'trips.truck', 'trips.localityFrom', 'trips.localityTo', 'transactions']);
        $trips = $journey->trips->sortBy('start_time');

        $startFuel = $trips->first()->fuel_remains;
        $finishFuel = $trips->last()->fuel_remains;

        if (!$startFuel || !$finishFuel) {
            Toast::warning(__('To calculate fuel consumption please set fuel remains for first and last trips'));
        }

        $distance = 0;
        $fuelReplenishmentTotal = 0;

        foreach ($trips as $trip) {
            $distance += $trip->distance;
        }

        foreach ($journey->trips->pluck('truck')->unique() as $truck) {
            $fuelReplenishment = FuelTransaction::where([
                'truck_id'         => $truck->id,
                'transaction_type' => FuelTransaction::TYPE_EXPENSE,
            ])
                ->whereBetween('datetime', [$trips->first()->start_time, $trips->last()->finish_time])
                ->get()
                ->sum(fn($e) => $e->quantity);

            $fuelReplenishmentTotal += $fuelReplenishment;
        }

        $fuelUsed = $startFuel && $finishFuel ? $startFuel - $finishFuel + $fuelReplenishmentTotal : null;

        $income = 0;
        $expense = 0;
        $transactionsTotal = 0;

        foreach ($journey->transactions as $transaction) {
            $transaction->amount > 0 ? $income += $transaction->amount : $expense += $transaction->amount;
            $transactionsTotal += $transaction->amount;
        }

        return [
            'journey'              => $journey,
            'trips'                => $trips,
            'journey.transactions' => $journey->transactions->sortBy('amount', SORT_REGULAR, true),
            'journey.date_from'    => $journey->date_from->format('d.m.y'),
            'journey.date_to'      => $journey->date_to->format('d.m.y'),
            'journey.duration'     => $journey->date_to->diffInDays($journey->date_from),

            'fuel.replenishment' => $fuelReplenishmentTotal,
            'fuel.used'          => $fuelUsed,
            'fuel.consumption'   => ViewHelper::averageFuelConsumption($fuelUsed, $distance) . ' ' . __('l/100 km'),
            'fuel.distance'      => $distance,

            'transactions.income'  => $income,
            'transactions.expense' => abs($expense),
            'transactions.total'   => $transactionsTotal,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ViewHelper::formatJourneyName($this->journey);
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.journeys.item',
        ];
    }

    /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Link::make(__('Edit'))
                ->route('platform.journeys.edit', $this->journey->id)
                ->icon('pencil'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->journey->exists),

        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::blank([
                TripListLayout::class,

                Layout::legend('journey', [
                    Sight::make('comment', __('Comment'))
                        ->render(function (Journey $journey) {
                            return $journey->comment;
                        }),
                ])
                    ->title(__('Comment')),

                Layout::table('journey.transactions', [
                    TD::make('name', __('Name'))
                        ->cantHide(),

                    TD::make('amount', __('Amount'))
                        ->render(function (JourneyTransaction $transaction) {
                            $isExpense = $transaction->amount < 0;

                            return '<span class="'
                                . ($isExpense ? 'text-danger' : 'text-success')
                                . "\">$transaction->amount</span>";
                        })
                        ->cantHide(),

                    TD::make('comment', __('Comment'))
                        ->cantHide(),
                ])
                    ->title(__('Transactions')),

                Layout::metrics([
                    'Income'  => 'transactions.income',
                    'Expense' => 'transactions.expense',
                    'Total'   => 'transactions.total',
                ])
                    ->title(__('Transactions Summary')),

                Layout::metrics([
                    'Fuel Replenishment' => 'fuel.replenishment',
                    'Fuel Used'          => 'fuel.used',
                    'Total Distance'     => 'fuel.distance',
                    'Fuel Consumption'   => 'fuel.consumption',
                ])
                    ->title(__('Fuel Analytics')),

                Layout::metrics([
                    'Date From'       => 'journey.date_from',
                    'Date To'         => 'journey.date_to',
                    'Duration (days)' => 'journey.duration',
                ])
                    ->title(__('Dates')),
            ]),

        ];
    }
}
