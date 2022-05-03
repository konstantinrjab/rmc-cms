<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Orchid\Layouts\Client\ClientListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientListScreen extends Screen
{
    public function query(): iterable
    {
        return [
            'clients' => Client::filters()->defaultSort('name')->paginate(),
        ];
    }

    public function name(): ?string
    {
        return __('Clients');
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
                ->route('platform.clients.create'),
        ];
    }

    public function layout(): iterable
    {
        return [
            Layout::columns([
                ClientListLayout::class,
            ]),
        ];
    }

    public function remove(Request $request): void
    {
        Client::findOrFail($request->get('id'))->delete();

        Toast::info(__('Client was removed'));
    }
}
