<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Fuel;

use App\Models\FuelTransaction;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

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
            'transaction'              => $transaction,
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
        ];
    }
}
