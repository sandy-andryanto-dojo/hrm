$(document).ready(function() {

    var getStatus = function(status) {
        var items = {};
        switch (parseInt(status)) {
            case 0:
                items = { "label": "warning", "text": "Menunggu Persetujuan" };
                break;
            case 1:
                items = { "label": "success", "text": "Sudah disetujui" };
                break;
            case 2:
                items = { "label": "danger", "text": "Di Tolak" };
                break;
            default:
                items = { "label": "primary", "text": "-" };
                break;
        }
        return tableLabelStatus(items.label, items.text);
    }

    var route = "employee_mutations";
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
                "data": "employee_number"
            },
            {
                "targets": 2,
                "data": "employee_name",
            },
            {
                "targets": 3,
                "data": "division_from_name",
            },
            {
                "targets": 4,
                "data": "division_target_name",
            },
            {
                "targets": 5,
                "data": "manager_name",
            },
            {
                "targets": 6,
                "data": "reason",
            },
            {
                "targets": 7,
                "data": "is_approved",
                "render": function(data, type, row, meta) {
                    return getStatus(data);
                }
            },
            {
                "targets": 8,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    if ($(".btn-create-data").length && parseInt(row.is_approved) == 0) {
                        return appDataTable.action(route, row.id, "employees");
                    } else {
                        if (parseInt(row.is_approved) == 1) {
                            return "<a href='javascript:void(0);' class='btn btn-sm btn-success' disabled='disabled'><i class='fa fa-check'></i></a>";
                        } else {
                            return "<a href='javascript:void(0);' data-id='" + row.id + "' class='btn btn-sm btn-primary btn-approve'><i class='fa fa-gavel'></i></a>";
                        }
                    }

                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    if ($("#employee_id").length) {

        $("#employee_id").select2({
            placeholder: "-- Pilih Pegawai --",
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

        $('#employee_id').on('select2:select', function(e) {
            var data = e.params.data;
            var id = data.id;
            if (id) {
                headerRequest();
                $.post(BASE_URL + "/api/find/employee/" + id, function(result) {
                    if (result.division) {
                        $("#division_from_name").val(result.division.name);
                        $("#division_from_id").val(result.division.id);
                    } else {
                        $("#division_from_name").val("-");
                        $("#division_from_id").val("");
                    }
                });
            }

        });

    }

    $("body").on("click", ".btn-approve", function(e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        $("#eid").val(id);
        swal({
            title: "Konfirmasi Persetujuan",
            text: "Apakah anda yakin ?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonColor: "#ec6c62"
        }, function() {
            $("#form-approve").unbind('submit').submit();
        });
        return false;
    });

});