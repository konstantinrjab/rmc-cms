<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Fuel;

use App\Helpers\ViewHelper;
use App\Models\FuelTransaction;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Facades\Layout;

class FuelTransactionItemScreen extends Screen
{
    /**
     * @var FuelTransaction
     */
    public FuelTransaction $transaction;

    /**
     * Query data.
     *
     * @param FuelTransaction $transaction
     *
     * @return array
     */
    public function query(FuelTransaction $transaction): iterable
    {

        return [
            'transaction' => $transaction,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Fuel Transaction');
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.fuel_transactions.see',
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
                ->route('platform.journeys.edit', $this->transaction->id)
                ->icon('pencil'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->transaction->exists),

        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::legend('transaction', [
                Sight::make('transaction_type', __('Transaction Type'))->render(fn($e) => match ($e->transaction_type) {
                    FuelTransaction::TYPE_INCOME => __('Income'),
                    FuelTransaction::TYPE_EXPENSE => __('Expense'),
                }),
                Sight::make('fuel_type', __('Fuel Type')),
                Sight::make('quantity', __('Quantity')),
                Sight::make('source_id', __('Source'))->render(fn($e) => FuelTransaction::getSources()[$e->source_id]),
                Sight::make('truck_id', __('Truck'))->render(fn($e) => $e->truck ? ViewHelper::formatTruckName($e->truck) : ''),
                Sight::make('consumer_type', __('Consumer Type'))->render(fn($e) => match ($e->consumer_type) {
                    FuelTransaction::TYPE_OWN_STATION => __('Own Station'),
                    FuelTransaction::TYPE_TRUCK => __('Truck'),
                    FuelTransaction::TYPE_OTHER => __('Other'),
                }),
                Sight::make('price', __('Price')),
                Sight::make('operator_id', __('Operator'))->render(fn($e) => $e->operator->name),
                Sight::make('comment', __('Comment')),
                Sight::make('datetime', __('Date'))->render(fn($e) => $e->datetime->format('d.m.y')),
            ]),
        ];
    }
}
