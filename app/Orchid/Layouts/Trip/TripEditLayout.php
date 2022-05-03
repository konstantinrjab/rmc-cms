<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Trip;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class TripEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
//            Input::make('trip.name')
//                ->type('text')
//                ->max(255)
//                ->required()
//                ->title(__('Name'))
//                ->placeholder(__('Name')),
//
//            Input::make('trip.position')
//                ->type('text')
//                ->title(__('Position'))
//                ->placeholder(__('Position')),
        ];
    }
}
