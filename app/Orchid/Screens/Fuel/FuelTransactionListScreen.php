<?php

namespace App\Orchid\Screens\Fuel;

use App\Models\FuelTransaction;
use App\Orchid\Layouts\Fuel\FuelTransactionListLayout;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class FuelTransactionListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'fuelTransactions' => FuelTransaction::filters()->with(['truck', 'operator'])->defaultSort('datetime', 'desc')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Fuel Transactions');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.fuel_transactions.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                FuelTransactionListLayout::class,
            ]),
        ];
    }
}
