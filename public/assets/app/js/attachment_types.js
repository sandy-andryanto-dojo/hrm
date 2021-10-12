$(document).ready(function() {

    var route = "attachment_types";
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
                "targets": 2,
                "data": "description",
            },
            {
                "targets": 3,
                "data": "is_required",
                "render": function(data, type, row, meta) {
                    if (parseInt(data) === 1) {
                        return tableLabelStatus("success", "Wajib");
                    } else {
                        return tableLabelStatus("warning", "Tidak Wajib");
                    }
                }
            },
            {
                "targets": 4,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "master");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);




});