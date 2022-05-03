<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Journey;

use App\Models\Journey;
use App\Models\Trip;
use App\Orchid\Layouts\Journey\JourneyEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class JourneyEditScreen extends Screen
{
    /**
     * @var Journey
     */
    public Journey $journey;

    /**
     * Query data.
     *
     * @param Journey $journey
     *
     * @return array
     */
    public function query(Journey $journey): iterable
    {
        return [
            'journey' => $journey,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return ($this->journey->exists ? __('Edit') : __('Create')) . ': ' . __('Journey');
    }

    /**
     * @return iterable|null
     */
    public function permission(): ?iterable
    {
        return [
//            'platform.journeys',
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
                ->canSee($this->journey->exists),

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

            Layout::block(JourneyEditLayout::class)
                ->title(__('Fill out the form.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->journey->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param Journey $journey
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Journey $journey, Request $request)
    {
        $data = $request->get('journey');

        $journey
            ->fill($data)
            ->save();

        if ($data['trip_ids']) {
            $journey->trips()->update(['journey_id' => null]);
            Trip::whereIn('id', $data['trip_ids'])->update(['journey_id' => $journey->id]);
        }

        Toast::info(__('Journey was saved.'));

        return redirect()->route('platform.journeys');
    }

    /**
     * @param Journey $journey
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(Journey $journey)
    {
        $journey->trips()->dissociate();
        $journey->delete();

        Toast::info(__('Journey was removed'));

        return redirect()->route('platform.journeys');
    }
}
