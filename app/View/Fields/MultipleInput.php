<?php

declare(strict_types=1);

namespace App\View\Fields;

use Illuminate\Database\Eloquent\Model;
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

        $value = $this->get('value');
        $content = [];

        if (!$value->isEmpty()) {
            foreach ($value as $item) {
                $content[] = $this->renderInputs($item);
//                ->withErrors($errors);
            }
        }

        return view('fields.multiple-input-wrapper', [
            'attributes'   => $this->getAllowAttributes(),
            'value'        => $value,
            'properties'   => $this->get('properties'),
            'content'      => implode($content),
            'rowTemplate' => $this->renderInputs(),
        ]);
    }

    protected function renderInputs(?Model $item = null): string
    {
        $renderers = [];
        foreach ($this->get('renderers') as $origRenderer) {
            /** @var Field $origRenderer */
            $renderer = clone $origRenderer;

            if ($item) {
                $renderer->value($item->{$renderer->get('name')});
                $renderer->name($this->get('name') . "[$item->id][" . $renderer->get('name') . ']');
            } else {
                $renderer->name($this->get('name') . "[0][" . $renderer->get('name') . ']');
            }
            $renderers[] = $renderer;
        }

        return view($this->view, array_merge($this->getAttributes(), [
            'attributes'     => $this->getAllowAttributes(),
            'dataAttributes' => $this->getAllowDataAttributes(),
            'id'             => $this->get('id'),
            'old'            => $this->getOldValue(),
            'slug'           => $this->getSlug(),
            'oldName'        => $this->getOldName(),
            'typeForm'       => $this->typeForm ?? $this->vertical()->typeForm,

            'hidden'    => is_null($item),
            'renderers' => $renderers,
            'item'      => $item,
        ]))->render();
    }
}
