<?php

namespace App\Orchid\Layouts\Fuel;

use App\Helpers\ViewHelper;
use App\Models\Employee;
use App\Models\FuelTransaction;
use App\Models\Truck;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FuelTransactionListLayout extends Table
{
    protected $title = 'Fuel Transactions';

    protected $target = 'fuelTransactions';

    public function columns(): array
    {
        $trucks = Truck::all();
        $truckOptions = $trucks->keyBy('id')->map(fn($e) => ViewHelper::formatTruckName($e));

        return [
            TD::make('id', __('ID'))
                ->sort()
                ->render(function (FuelTransaction $transaction) {
                    return '<a href="' . route('platform.fuel_transactions.item', $transaction->id) . '"><span class="fw-bolder">' . $transaction->id . '</span></a>';
                }),

            TD::make('truck_id', __('Consumer'))
                ->sort()
                ->filter(TD::FILTER_SELECT, $truckOptions)
                ->render(function (FuelTransaction $transaction) {
                    if ($transaction->consumer_type == FuelTransaction::TYPE_OWN_STATION) {
                        return '<span class="text-info">' . __('Own Station') . '</span>';
                    }

                    return $transaction->truck ? ViewHelper::formatTruckName($transaction->truck) : "<span class='text-primary'>$transaction->comment</span>";
                }),

            TD::make('transaction_type', __('Transaction Type'))
                ->defaultHidden()
                ->sort()
                ->filter(TD::FILTER_SELECT, ViewHelper::selectOptions([FuelTransaction::TYPE_EXPENSE, FuelTransaction::TYPE_INCOME]))
                ->render(function (FuelTransaction $transaction) {
                    return __($transaction->transaction_type);
                }),

            TD::make('quantity', __('Quantity'))
                ->sort()
                ->filter(TD::FILTER_NUMBER_RANGE)
                ->render(function (FuelTransaction $transaction) {
                    return '<span class="'
                        . ($transaction->transaction_type == FuelTransaction::TYPE_EXPENSE ? 'text-danger' : 'text-success')
                        . "\">$transaction->quantity</span>";
                }),

            TD::make('datetime', __('Date'))
                ->sort()
                ->filter(TD::FILTER_DATE_RANGE)
                ->render(function (FuelTransaction $transaction) {
                    return $transaction->datetime->format('Y-m-d H:i');
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (FuelTransaction $transaction) {
                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list([

                            Link::make(__('Edit'))
                                ->route('platform.fuel_transactions.edit', $transaction->id)
                                ->icon('pencil'),

                            Button::make(__('Delete'))
                                ->icon('trash')
                                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                                ->method('remove', [
                                    'id' => $transaction->id,
                                ]),
                        ]);
                }),
        ];
    }
}
