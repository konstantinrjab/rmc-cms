<?php

declare(strict_types=1);

namespace App\View\Fields;

use Orchid\Screen\Concerns\Multipliable;
use Orchid\Screen\Field;

class MultipleInput extends Field
{
    use Multipliable;

    /**
     * @var string
     */
    protected $view = 'fields.multiple-input';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'    => 'form-control',
        'datalist' => [],
    ];

    /**
     * Input constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $mask = $this->get('mask');

            if (is_array($mask)) {
                $this->set('mask', json_encode($mask));
            }
        });
    }

    public function render()
    {
        if (!$this->isSee()) {
            return;
        }

        $this
            ->checkRequired()
            ->modifyName()
            ->modifyValue()
            ->runBeforeRender()
            ->translate()
            ->checkError();

        $id = $this->getId();
        $this->set('id', $id);

        $errors = $this->getErrorsMessage();

        $content = [];

        foreach ($this->get('value') as $item) {
            $renderers = $this->get('renderers');

            foreach ($renderers as $renderer) {
                /** @var Field $renderer */
                $renderer->value($item->{$renderer->get('name')});
            }

            $content[] = view($this->view, array_merge($this->getAttributes(), [
                'attributes'     => $this->getAllowAttributes(),
                'dataAttributes' => $this->getAllowDataAttributes(),
                'id'             => $id,
                'old'            => $this->getOldValue(),
                'slug'           => $this->getSlug(),
                'oldName'        => $this->getOldName(),
                'typeForm'       => $this->typeForm ?? $this->vertical()->typeForm,


                'renderers' => $renderers,
                'item'      => $item,
            ]))->render();
//                ->withErrors($errors);
        }

        return view('fields.multiple-input-wrapper', [
            'attributes' => $this->getAllowAttributes(),
            'value'      => $this->get('value'),
            'properties' => $this->get('properties'),
            'content'    => implode($content),
        ]);
    }
}
