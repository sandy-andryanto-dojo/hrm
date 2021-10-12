$(document).ready(function() {

    var route = "districts";
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
                "data": "province_name"
            },
            {
                "targets": 2,
                "data": "regency_name"
            },
            {
                "targets": 3,
                "data": "name",
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

    var renderRegency = function(id) {
        $("#regency_id").select2({
            placeholder: "-- Pilih Kabupaten / Kota --",
            allowClear: true,
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer ' + API_TOKEN,
                },
                url: BASE_URL + "/api/select2/regencies/" + id,
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

    if ($("#province_id").length) {
        var province_id = $("#province_id").val() || 0;
        renderRegency(province_id);
    }

    if ($("#province_id").length) {
        $('#province_id').on('select2:select', function(e) {
            var data = e.params.data;
            var id = data.id;
            $('#regency_id').val(null).trigger('change');
            renderRegency(id);
        });
    }



});