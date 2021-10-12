$(document).ready(function() {

    var route = "positions";
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
                "data": "code"
            },
            {
                "targets": 2,
                "data": "name",
            },
            {
                "targets": 3,
                "data": "hour_salary",
                "render": function(data, type, row, meta) {
                    return numberFormat(data, 2, ",", ".");
                }
            },
            {
                "targets": 4,
                "data": "month_salary",
                "render": function(data, type, row, meta) {
                    return numberFormat(data, 2, ",", ".");
                }
            },
            {
                "targets": 5,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "organization");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    if ($('#hour_salary').length) {
        $('#hour_salary').mask('#.##0,00', {
            reverse: true
        });
    }

    if ($('#month_salary').length) {
        $('#month_salary').mask('#.##0,00', {
            reverse: true
        });
    }


});