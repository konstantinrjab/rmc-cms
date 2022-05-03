<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Truck;

use App\Models\Truck;
use App\Orchid\Layouts\Truck\TruckEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TruckEditScreen extends Screen
{
    /**
     * @var Truck
     */
    public Truck $truck;

    /**
     * Query data.
     *
     * @param Truck $truck
     *
     * @return array
     */
    public function query(Truck $truck): iterable
    {
        return [
            'truck' => $truck,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->truck->exists ? 'Edit Truck' : 'Create Truck';
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
//            'platform.truck',
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
                ->canSee($this->truck->exists),

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

            Layout::block(TruckEditLayout::class)
                ->title(__('Truck Information'))
                ->description(__('Update your truck information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->truck->exists)
                        ->method('save')
                ),

        ];
    }

    /**
     * @param Truck $truck
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Truck $truck, Request $request)
    {
        $data = $request->get('truck');

        $truck
            ->fill($data)
            ->save();

        Toast::info(__('Truck was saved.'));

        return redirect()->route('platform.trucks');
    }

    /**
     * @param Truck $truck
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception
     *
     */
    public function remove(Truck $truck)
    {
        $truck->delete();

        Toast::info(__('Truck was removed'));

        return redirect()->route('platform.trucks');
    }
}
