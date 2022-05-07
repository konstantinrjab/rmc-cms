<table class="table table-bordered" id="dynamicTable">
    <tbody>
    {!! $content !!}
    <tr>
        <td>
            <button type="button" class="btn btn-success" data-type="multiple-input-button-add">Add More</button>
        </td>
    </tr>
    </tbody>
</table>

<script type="text/javascript">
    $("[data-type='multiple-input-button-add']").click(function () {

        let row = $("#dynamicTable [data-type='multiple-input-row']:last");

        row.find("select").each(function (index) {
            if ($(this).hasClass("select2-hidden-accessible")) {
                $(this).select2('destroy');
            }
        });

        let newRow = row.clone()

        newRow.find('input, select').each(function (index) {
            $(this).attr('id', Math.random()).val(null)
        });

        $("#dynamicTable > tr:last").before(newRow.html())
        newRow.insertBefore("#dynamicTable tr:last")

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
