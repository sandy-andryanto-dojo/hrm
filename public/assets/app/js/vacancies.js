$(document).ready(function() {

    var route = "vacancies";
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
                "data": "vacancy_name"
            },
            {
                "targets": 2,
                "data": "type_name"
            },
            {
                "targets": 3,
                "data": "job_name"
            },
            {
                "targets": 4,
                "data": "position_name"
            },
            {
                "targets": 5,
                "data": "division_name"
            },
            {
                "targets": 6,
                "data": "start_date"
            },
            {
                "targets": 7,
                "data": "end_date"
            },
            {
                "targets": 8,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "recruitment");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    if ($('.input_money').length) {
        $('.input_money').mask('#.##0,00', {
            reverse: true
        });
    }

});