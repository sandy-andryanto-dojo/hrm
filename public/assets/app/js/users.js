$(document).ready(function() {

    var route = "users";
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
                "data": "email",
            },
            {
                "targets": 3,
                "data": "phone",
            },
            {
                "targets": 4,
                "data": "access_groups",
            },
            {
                "targets": 5,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "settings");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

});