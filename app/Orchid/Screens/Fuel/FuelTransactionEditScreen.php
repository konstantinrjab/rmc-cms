<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Fuel;

use App\Models\FuelTransaction;
use App\Orchid\Layouts\Fuel\FuelTransactionEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FuelTransactionEditScreen extends Screen
{
    /**
     * @var FuelTransaction
     */
    public $fuelTransaction;

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
            'fuelTransaction' => $transaction,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->fuelTransaction->exists ? __('Edit') : __('Create')) . ': ' . __('Fuel Transaction');
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'content.fuel_transactions',
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
            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->fuelTransaction->exists),

            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [

            Layout::block(FuelTransactionEditLayout::class)
                ->title(__('Fill out the form.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->fuelTransaction->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param FuelTransaction $transaction
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(FuelTransaction $transaction, Request $request)
    {
        $data = $request->get('fuelTransaction');

        $transaction
            ->fill($data)
            ->save();

        Toast::info(__('Transaction was saved.'));

        return redirect()->route('platform.fuel_transactions');
    }

    /**
     * @param FuelTransaction $transaction
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(FuelTransaction $transaction)
    {
        $transaction->delete();

        Toast::info(__('Transaction was removed'));

        return redirect()->route('platform.fuel_transactions');
    }
}
