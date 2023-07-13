function del(table, id) {
    $.post("./api/del.php", { table, id }, () => location.reload());
}
function edit(table, id) {
    $.getJSON(`api/get_${table}.php`, { id }, (data) => {
        $("#title").html(data.name);
        $("#editMinute").val(data.minute);
        $("#editWaiting").val(data.waiting);
        $("#editId").val(data.id);
    });
}