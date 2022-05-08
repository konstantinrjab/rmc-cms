<div class="form-group mb-0" data-type="multiple-input-wrapper">

    @php($tableId = uniqid())

    @isset($attributes['title'])
        <label for="{{ $tableId }}" class="form-label">
            {{ $attributes['title'] }}
        </label>
    @endisset

    <table class="table table-bordered dynamicTable" id="{{ $tableId }}">
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

        row.find("select").each(function (index) {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }
        });

        let newRow = row.clone()
        let nameIndex = Math.floor(Math.random() * -9999)

        newRow.find('input, select').each(function (index) {
            $(this).attr('id', Math.random()).val(null)
            let name = $(this).attr('name');
            $(this).attr('name', name.replace(/\[0]/g, '[' + nameIndex + ']'))
        });
        newRow.show()

        $(".dynamicTable > tr:last").before(newRow.html())
        newRow.insertAfter(".dynamicTable tr:last")

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
