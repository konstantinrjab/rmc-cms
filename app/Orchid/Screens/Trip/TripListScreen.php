<?php

namespace App\Orchid\Screens\Trip;

use App\Models\Trip;
use App\Orchid\Layouts\Trip\TripListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TripListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'trips' => Trip::filters()->with(['client', 'employee', 'localityFrom', 'localityTo'])->defaultSort('start_time')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Trips');
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
                ->route('platform.trips.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                TripListLayout::class,
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        Trip::findOrFail($request->get('id'))->delete();

        Toast::info(__('Trip was removed'));
    }
}
