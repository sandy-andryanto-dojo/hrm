$(document).ready(function() {

    var route = "audits";
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
                "data": "username"
            },
            {
                "targets": 2,
                "data": "email"
            },
            {
                "targets": 3,
                "data": "event",
                "render": function(data, type, row, meta) {
                    return "<strong>" + ucFirst(data) + "</strong>";
                }
            },
            {
                "targets": 4,
                "data": "url"
            },
            {
                "targets": 5,
                "data": "ip_address"
            },
            {
                "targets": 6,
                "data": "created_at"
            },
        ]
    };

    appDataTable.render(renderConfig);

});