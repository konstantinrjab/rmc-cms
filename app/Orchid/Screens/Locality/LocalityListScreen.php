<?php

namespace App\Orchid\Screens\Locality;

use App\Models\Locality;
use App\Orchid\Layouts\Locality\LocalityListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LocalityListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'localities' => Locality::filters()->defaultSort('name')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Localities');
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
                ->route('platform.localities.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                LocalityListLayout::class,
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        Locality::findOrFail($request->get('id'))->delete();

        Toast::info(__('Locality was removed'));
    }
}
