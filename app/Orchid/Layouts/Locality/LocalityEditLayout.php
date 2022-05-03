<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Locality;

use App\Models\Locality;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class LocalityEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        $regions = Locality::distinct()->toBase()->get('region')->pluck('region')->toArray();

        return [
            Input::make('locality.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Select::make('locality.region')
                ->options(array_combine($regions, $regions))
                ->required()
                ->title(__('Region'))
                ->placeholder(__('Region')),

            Input::make('locality.district')
                ->type('text')
                ->max(255)
                ->title(__('District'))
                ->placeholder(__('District')),

            Input::make('locality.latitude')
                ->type('text')
                ->max(255)
                ->title(__('Latitude'))
                ->placeholder(__('Latitude')),

            Input::make('locality.longitude')
                ->type('text')
                ->max(255)
                ->title(__('Longitude'))
                ->placeholder(__('Longitude')),
        ];
    }
}
