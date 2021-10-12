$(document).ready(function() {

    var renderConfig = {
        "table": "#table",
        "route": "workers",
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
                "data": "employee_number"
            },
            {
                "targets": 2,
                "data": "employee_name",
            },

            {
                "targets": 3,
                "data": "division_name",
            },
            {
                "targets": 4,
                "data": "position_name",
            },
            {
                "targets": 5,
                "data": "type_name",
            },
            {
                "targets": 6,
                "data": "allowances",
                "orderable": false,
                "render": function(data, type, row, meta) {
                    if (parseInt(data) > 0) {
                        return tableLabelStatus("success", "Sudah di isi");
                    } else {
                        return tableLabelStatus("danger", "Belum di isi");
                    }
                }
            },
            {
                "targets": 7,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    let buttons = new Array();
                    buttons.push("<a href='" + BASE_URL + "/employees/employee_allowances/" + row.id + "' class='btn btn-info btn-sm waves-effect waves-light btn-edit'><i class='fa fa-search'></i></a>");
                    buttons.push("<a href='" + BASE_URL + "/employees/employee_allowances/" + row.id + "/edit' class='btn btn-primary btn-sm waves-effect waves-light btn-detail'><i class='fa fa-edit'></i></a>");
                    return buttons.join("&nbsp;");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    if ($('.input-cost').length) {
        $('.input-cost').mask('#.##0,00', {
            reverse: true
        });
    }

});