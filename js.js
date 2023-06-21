$("#addMinute,#editMinute,#addWaiting,#editWaiting").on("invalid", function () {
    this.setCustomValidity("行駛時間或停留時間不應小於0")
})
$("#addMinute,#editMinute,#addWaiting,#editWaiting").on("input", function () {
    this.setCustomValidity("")
})


$(".sw").on("click", function () {
    let ids = $(this).data('id').split("-")
    console.log(ids)
    $.post("./api/sw.php", { ids }, function (res) {
        location.reload();
    })
})

function del(table, id) {
    $.post("./api/del.php", { table, id }, () => {
        location.reload();
    })
}
function edit(table, id) {
    let api;
    switch (table) {
        case 'bus':
            api = "api/get_bus.php";
            break;
        case 'station':
            api = "api/get_station.php";

            break;
    }
    $.getJSON(api, { id }, (data) => {
        $("#title").html(data.name);
        $("#editMinute").val(data.minute);

        if (table == 'station') {
            $("#editWaiting").val(data.waiting);
        } $("#editId").val(data.id);
    })
}
