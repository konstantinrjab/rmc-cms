<?php

namespace App\Orchid\Layouts\Fuel;

use App\Helpers\ViewHelper;
use App\Models\Employee;
use App\Models\FuelTransaction;
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
        $employees = Employee::all();

        return [
            TD::make('subject_id', __('Subject'))
                ->sort()
                ->filter(TD::FILTER_SELECT, $employees->keyBy('id')->map(fn($e) => $e->name))
                ->render(function (FuelTransaction $transaction) {
                    return $transaction->subject->name;
                }),

            TD::make('transaction_type', __('Transaction Type'))
                ->sort()
                ->filter(TD::FILTER_SELECT, ViewHelper::selectOptions([FuelTransaction::TYPE_SALE, FuelTransaction::TYPE_PURCHASE]))
                ->render(function (FuelTransaction $transaction) {
                    return $transaction->transaction_type;
                }),

            TD::make('quantity', __('Quantity'))
                ->sort()
                ->filter(TD::FILTER_NUMBER_RANGE)
                ->render(function (FuelTransaction $transaction) {
                    return '<span class="'
                        . ($transaction->transaction_type == FuelTransaction::TYPE_SALE ? 'text-danger' : 'text-success')
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
