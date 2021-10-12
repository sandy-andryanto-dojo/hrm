$(document).ready(function() {

    var route = "candidates";
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
                "data": "identity_name"
            },
            {
                "targets": 2,
                "data": "identity_number"
            },
            {
                "targets": 3,
                "data": "candidate_name"
            },
            {
                "targets": 4,
                "data": "gender_name",
            },
            {
                "targets": 5,
                "data": "email",
            },
            {
                "targets": 6,
                "data": "phone",
            },
            {
                "targets": 7,
                "data": "country_name",
            },
            {
                "targets": 8,
                "data": "umur",
            },
            {
                "targets": 9,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "recruitment");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);




});