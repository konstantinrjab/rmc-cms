<?php

namespace App\Orchid\Screens\Journey;

use App\Models\Journey;
use App\Orchid\Layouts\Journey\JourneyListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class JourneyListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'journeys' => Journey::filters()->defaultSort('name')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Journeys');
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
                ->route('platform.journeys.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                JourneyListLayout::class,
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        Journey::findOrFail($request->get('id'))->delete();

        Toast::info(__('Journey was removed'));
    }
}
