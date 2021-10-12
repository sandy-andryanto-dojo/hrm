$(document).ready(function() {

    var route = "roles";
    var renderConfig = {
        "table": "#table",
        "route": route,
        "request": "POST",
        "column": [{
                "targets": 0,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "targets": 1,
                "data": "name"
            },
            {
                "targets": 3,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "settings");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    $("#checked-all").change(function(e) {
        e.preventDefault();
        $('input:checkbox').not(this).not(":disabled").prop('checked', this.checked);
        return false;
    });

    $(".action").change(function(e) {
        e.preventDefault();
        let id = $(this).attr("id");
        $('input:checkbox.' + id).not(this).prop('checked', this.checked).change();
        return false;
    });



});