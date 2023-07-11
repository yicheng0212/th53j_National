$("#addMinute, #editMinute, #addWaiting, #editWaiting").on({
    invalid: function () {
        this.setCustomValidity("行駛時間或停留時間不應小於0");
    },
    input: function () {
        this.setCustomValidity("");
    }
});

function del(table, id) {
    $.post("./api/del.php", { table, id }, () => location.reload());
}
function edit(table, id) {
    let api = `api/get_${table}.php`;
    $.getJSON(api, { id }, (data) => {
        $("#title").html(data.name);
        $("#editMinute").val(data.minute);
        if (table === 'station') {
            $("#editWaiting").val(data.waiting);
        }
        $("#editId").val(data.id);
    });
}