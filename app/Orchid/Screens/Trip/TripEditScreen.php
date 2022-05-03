<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Trip;

use App\Models\Trip;
use App\Orchid\Layouts\Trip\TripEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TripEditScreen extends Screen
{
    /**
     * @var Trip
     */
    public Trip $trip;

    /**
     * Query data.
     *
     * @param Trip $trip
     *
     * @return array
     */
    public function query(Trip $trip): iterable
    {
        return [
            'trip' => $trip,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->trip->exists ? 'Edit Trip' : 'Create Trip';
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
//            'platform.trips',
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
                ->canSee($this->trip->exists),

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

            Layout::block(TripEditLayout::class)
                ->title(__('Client Information'))
                ->description(__('Update trip information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->trip->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param Trip $trip
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Trip $trip, Request $request)
    {
        $data = $request->get('trip');

        $trip
            ->fill($data)
            ->save();

        Toast::info(__('Trip was saved.'));

        return redirect()->route('platform.trips');
    }

    /**
     * @param Trip $trip
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(Trip $trip)
    {
        $trip->delete();

        Toast::info(__('Trip was removed'));

        return redirect()->route('platform.trips');
    }
}
