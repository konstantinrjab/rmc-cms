<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Journey;

use App\Models\Journey;
use App\Models\JourneyTransaction;
use App\Models\Trip;
use App\Orchid\Layouts\Journey\JourneyEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Illuminate\Support\Facades\DB;

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

            Layout::blank([
                new JourneyEditLayout(),
            ]),

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

        DB::transaction(function () use ($journey, $data) {
            $journey
                ->fill($data)
                ->save();

            // TODO: refactor? make it more obvious?
            Trip::where('start_time', '>=', $data['date_from'])
                ->where('finish_time', '<=', $data['date_to'])
                ->where(['employee_id' => $data['employee_id']])
                ->whereNull('journey_id')
                ->update(['journey_id' => $journey->id]);

            // TODO: update relations, not recreate them
            $journey->transactions()->delete();

            if (!empty($data['transactions'])) {
                foreach ($data['transactions'] as $transaction) {
                    $transaction['journey_id'] = $journey->id;
                    JourneyTransaction::create($transaction);
                }
            }
        });

        Toast::info(__('Journey was saved.'));

        return redirect()->route('platform.journeys.item', $journey->id);
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
