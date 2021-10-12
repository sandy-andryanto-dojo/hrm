$(document).ready(function() {

    var route = "divisions";
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
                "data": "divison_name",
            },
            {
                "targets": 2,
                "data": "employee_name",
                "render": function(data, type, row, meta) {
                    return data ? data : "-";
                }
            },
            {
                "targets": 3,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "organization");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    if ($("#superior_id").length) {
        $("#superior_id").select2({
            placeholder: "-- Pilih Pimpinan --",
            allowClear: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + API_TOKEN,
                },
                url: BASE_URL + "/api/select2/employees",
                type: "POST",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function(data) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data
                    };
                },
                cache: true,
            }
        });
    }

});