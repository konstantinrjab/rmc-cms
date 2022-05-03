<?php

namespace App\Orchid\Screens\Truck;

use App\Models\Truck;
use App\Orchid\Layouts\Truck\TruckListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TruckListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'trucks' => Truck::filters()->defaultSort('name')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Trucks');
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
                ->route('platform.trucks.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                TruckListLayout::class,
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        Truck::findOrFail($request->get('id'))->delete();

        Toast::info(__('Truck was removed'));
    }
}
