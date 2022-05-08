<div class="form-group mb-0" data-type="multiple-input-wrapper">

    @php($tableId = uniqid())

    @isset($attributes['title'])
        <label for="{{ $tableId }}" class="form-label">
            {{ $attributes['title'] }}
        </label>
    @endisset

    <table class="table table-bordered" data-type="multiple-input-table" id="{{ $tableId }}">
        <tbody>
        {!! $content !!}
        </tbody>
    </table>
    <div data-type="row-example" style="display: none;">{{ $rowTemplate }}</div>
    <button type="button" class="btn btn-success" data-type="multiple-input-button-add">{{ __('Add More') }}</button>
</div>

<script type="text/javascript">
    $("[data-type='multiple-input-button-add']").click(function () {

        let row = $("[data-type='multiple-input-wrapper'] [data-type='row-example']:last");
        row = $(row.text())

        let nameIndex = Math.floor(Math.random() * -9999)

        row.find('input, select').each(function (index) {
            $(this).attr('id', Math.random()).val(null)
            let name = $(this).attr('name');
            $(this).attr('name', name.replace(/\[0]/g, '[' + nameIndex + ']'))
        });
        row.show()

        $("[data-type='multiple-input-table'] tbody").append(row)

        row.find("select").each(function (index) {
            $(this).select2({
                theme: "bootstrap"
            });
        });
    });

    $(document).on('click', '[data-action="delete-row"]', function () {
        $(this).parents('tr').remove();
    });
</script>
