<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Orchid\Layouts\Client\ClientEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClientEditScreen extends Screen
{
    /**
     * @var Client
     */
    public Client $client;

    /**
     * Query data.
     *
     * @param Client $client
     *
     * @return array
     */
    public function query(Client $client): iterable
    {
        return [
            'client' => $client,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->client->exists ? 'Edit Client' : 'Create Client';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Details such as name';
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.clients',
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
                ->canSee($this->client->exists),

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

            Layout::block(ClientEditLayout::class)
                ->title(__('Client Information'))
                ->description(__('Update your client information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->client->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param Client $client
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Client $client, Request $request)
    {
        $data = $request->get('client');

        $client
            ->fill($data)
            ->save();

        Toast::info(__('Client was saved.'));

        return redirect()->route('platform.clients');
    }

    /**
     * @param Client $client
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(Client $client)
    {
        $client->delete();

        Toast::info(__('Client was removed'));

        return redirect()->route('platform.clients');
    }
}
