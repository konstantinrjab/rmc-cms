<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Journey;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class JourneyEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('journey.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),
        ];
    }
}
