<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Locality;

use App\Models\Locality;
use App\Orchid\Layouts\Locality\LocalityEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LocalityEditScreen extends Screen
{
    /**
     * @var Locality
     */
    public Locality $locality;

    /**
     * Query data.
     *
     * @param Locality $locality
     *
     * @return array
     */
    public function query(Locality $locality): iterable
    {
        return [
            'locality' => $locality,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->locality->exists ? 'Edit Locality' : 'Create Locality';
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
//            'platform.localities',
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
                ->canSee($this->locality->exists),

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

            Layout::block(LocalityEditLayout::class)
                ->title(__('Locality Information'))
                ->description(__('Update locality information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->locality->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param Locality $locality
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Locality $locality, Request $request)
    {
        $data = $request->get('locality');

        $locality
            ->fill($data)
            ->save();

        Toast::info(__('Locality was saved.'));

        return redirect()->route('platform.localities');
    }

    /**
     * @param Locality $locality
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(Locality $locality)
    {
        $locality->delete();

        Toast::info(__('Locality was removed'));

        return redirect()->route('platform.localities');
    }
}
