<?php

namespace App\View\Fields;

use Orchid\Screen\Builder;
use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

abstract class MultipleInputLayout extends Layout
{
    protected $template = 'fields.multiple-input-layout';

    protected $title;

    abstract protected function attributes(): array;

    /**
     * @inheritDoc
    */
    public function build(Repository $repository)
    {
        $this->query = $repository;

        if (! $this->isSee()) {
            return;
        }

        $form = new Builder($this->attributes(), $repository);

        return view($this->template, [
            'form'  => $form->generateForm(),
            'title' => $this->title,
        ]);
    }
}
