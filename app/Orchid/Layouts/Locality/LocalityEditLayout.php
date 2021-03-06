<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Locality;

use App\Helpers\ViewHelper;
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
        return [
            Input::make('locality.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Select::make('locality.region')
                ->options(ViewHelper::selectOptions(Locality::REGIONS))
                ->required()
                ->empty()
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
