@php($rowId = uniqid())

<tr>
    @foreach($renderers as $renderer)
        <td data-row-id="{{ $rowId }}">
            {{ $renderer->id(uniqid())->render() }}
        </td>
    @endforeach
    <td>
        <button type="button" name="remove" class="btn btn-danger" data-action="delete-row"
                data-row-id="{{ $rowId }}">{{ __('Remove') }}</button>
    </td>
</tr>
