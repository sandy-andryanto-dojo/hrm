$(document).ready(function() {

    var route = "contacts";
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
                "data": "email",
            },
            {
                "targets": 3,
                "data": "phone",
            },
            {
                "targets": 4,
                "data": "website",
            },
            {
                "targets": 5,
                "data": "postal_code",
            },
            {
                "targets": 6,
                "data": "address",
            },
            {
                "targets": 7,
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