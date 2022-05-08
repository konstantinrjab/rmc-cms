<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Journey;

use App\Helpers\ViewHelper;
use App\Models\Journey;
use App\Models\JourneyTransaction;
use App\Models\Trip;
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

        $fuelReplenishment = 0;
        $mileage = 0;

        $trips = $journey->trips->sortBy('start_time');

        foreach ($trips as $trip) {
            $mileage += $trip->mileage;
            $fuelReplenishment += $trip->fuel_refill;
        }

        $startFuel = $trips->first()->fuel_remains;
        $finishFuel = $trips->last()->fuel_remains;

        if (!$startFuel || !$finishFuel) {
            Toast::warning(__('To calculate fuel consumption please set fuel remains for first and last trips'));
        }

        $fuelUsed = $startFuel && $finishFuel ? $startFuel - $finishFuel + $fuelReplenishment : null;

        $income = 0;
        $expense = 0;
        $transactionsTotal = 0;

        foreach ($journey->transactions as $transaction) {
            $transaction->amount > 0 ? $income += $transaction->amount : $expense += $transaction->amount;
            $transactionsTotal += $transaction->amount;
        }

        return [
            'journey'              => $journey,
            'journey.trips'        => $trips,
            'journey.transactions' => $journey->transactions->sortBy('amount', SORT_REGULAR, true),
            'journey.date_from'    => $journey->date_from->format('d.m.y'),
            'journey.date_to'      => $journey->date_to->format('d.m.y'),
            'journey.duration'     => $journey->date_to->diffInDays($journey->date_from),

            'fuel.replenishment' => $fuelReplenishment,
            'fuel.used'          => $fuelUsed,
            'fuel.consumption'   => number_format($fuelUsed / $mileage * 100, 2) . ' ' . __('l/100 km'),
            'fuel.mileage'       => $mileage,

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
//            'platform.journeys.see',
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

            Layout::table('journey.trips', [

                TD::make('trip_id', __('ID'))
                    ->render(function (Trip $trip) {
                        return '<a href="' . route('platform.trips.edit', $trip->id) . '">' . $trip->id . '</a>';
                    }),

                TD::make('client_id', __('Client'))
                    ->render(function (Trip $trip) {
                        return $trip->client->name;
                    }),

                TD::make('employee_id', __('Client'))
                    ->render(function (Trip $trip) {
                        return $trip->employee->name;
                    }),

                TD::make('truck_id', __('Truck'))
                    ->render(function (Trip $trip) {
                        return ViewHelper::formatTruckName($trip->truck);
                    }),

                TD::make('locality_from_id', __('Locality From'))
                    ->render(function (Trip $trip) {
                        return $trip->localityFrom->name;
                    }),

                TD::make('locality_to_id', __('Locality To'))
                    ->render(function (Trip $trip) {
                        return $trip->localityTo->name;
                    }),

                TD::make('status', __('Status'))
                    ->render(function (Trip $trip) {
                        return match ($trip->status) {
                            Trip::STATUS_ORDERED => '<span class="text-primary">' . __(Trip::STATUS_ORDERED) . '</span>',
                            Trip::STATUS_DONE => '<span class="text-success">' . __(Trip::STATUS_DONE) . '</span>',
                            Trip::STATUS_IN_PROGRESS => '<span class="text-warning">' . __(Trip::STATUS_IN_PROGRESS) . '</span>',
                        };
                    }),

                TD::make('mileage', __('Mileage'))
                    ->render(function (Trip $trip) {
                        return $trip->mileage;
                    }),

                TD::make('fuel_remains', __('Fuel Remains'))
                    ->render(function (Trip $trip) {
                        return $trip->fuel_remains;
                    }),

                TD::make('fuel_refill', __('Fuel Refill'))
                    ->render(function (Trip $trip) {
                        return $trip->fuel_refill;
                    }),

                TD::make('start_time', __('Start Time'))
                    ->render(function (Trip $trip) {
                        return $trip->start_time;
                    }),

                TD::make('finish_time', __('Finish Time'))
                    ->render(function (Trip $trip) {
                        return $trip->finish_time;
                    }),
            ]),

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
                'Total Mileage'      => 'fuel.mileage',
                'Fuel Consumption'   => 'fuel.consumption',
            ])
                ->title(__('Fuel Analytics')),

            Layout::metrics([
                'Date From'       => 'journey.date_from',
                'Date To'         => 'journey.date_to',
                'Duration (days)' => 'journey.duration',
            ])
                ->title(__('Dates')),
        ];
    }
}
