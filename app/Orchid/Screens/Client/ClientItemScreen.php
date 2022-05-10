<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Models\Trip;
use App\Orchid\Layouts\Trip\TripListLayout;
use Illuminate\Support\Collection;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ClientItemScreen extends Screen
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
        $client->load(['trips']);

        $format = function (Collection $trips, string $status): string {
            return number_format(
                $trips
                    ->filter(fn(Trip $trip) => $trip->payment_status == $status)
                    ->sum(fn(Trip $trip) => $trip->income)
            );
        };

        return [
            'client'             => $client,
            'trips'              => $client->trips,
            'metrics.debt'       => $format($client->trips, Trip::PAYMENT_STATUS_INVOICE_SENT),
            'metrics.no_invoice' => $format($client->trips, Trip::PAYMENT_STATUS_NO_INVOICE),
            'metrics.payed'      => $format($client->trips, Trip::PAYMENT_STATUS_PAYED),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Client') . ': ' . $this->client->name;
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.clients.item',
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

            Link::make(__('Edit'))
                ->route('platform.clients.edit', $this->client->id)
                ->icon('pencil'),

            Button::make(__('Remove'))
                ->icon('trash')
                ->confirm(__('Once item is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->client->exists),

        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::blank([

                TripListLayout::class,

                Layout::metrics([
                    'Debt'       => 'metrics.debt',
                    'No Invoice' => 'metrics.no_invoice',
                    'Payed'      => 'metrics.payed',
                ])
                    ->title('Total'),
            ]),
        ];
    }
}
