$(document).ready(function() {

    $(".foreign, .domestic").hide();

    var employee_id = $("#employee_id").text();
    var manager_id = $("#manager_id").text();

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

    var dataTableHistory = function() {
        let route = "employee_travels";
        let renderConfig = {
            "postData": [{
                    "name": "employee_id",
                    "value": employee_id
                },
                {
                    "name": "manager_id",
                    "value": manager_id
                },
                {
                    "name": "mode",
                    "value": 0
                }
            ],
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
                    "data": "destination",
                    "render": function(data, type, row, meta) {
                        return parseInt(data) === 1 ? "Dalam Negeri" : "Luar Negeri";
                    }
                },
                {
                    "targets": 2,
                    "data": "request_date",
                },
                {
                    "targets": 3,
                    "data": "start_date",
                },
                {
                    "targets": 4,
                    "data": "end_date",
                },
                {
                    "targets": 5,
                    "data": "reason",
                },
                {
                    "targets": 5,
                    "data": "is_approved",
                    "render": function(data, type, row, meta) {
                        return getStatus(data);
                    }
                },
                {
                    "targets": 6,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        var buttons = new Array();
                        var APP_URL = BASE_URL + "/submission/employee_travels";
                        var approved = parseInt(row.is_approved);
                        var id = row.id;
                        if (parseInt(approved) > 0) {
                            if (USER_CAN_VIEW == 1) buttons.push("<a href='" + APP_URL + "/" + id + "' data-id='" + id + "' class='btn btn-info btn-sm waves-effect waves-light btn-detail'><i class='fa fa-search'></i></a>");
                        } else {
                            if (USER_CAN_UPDATE == 1 && approved == 0) buttons.push("<a href='" + APP_URL + "/" + id + "/edit' data-id='" + id + "' class='btn btn-primary btn-sm waves-effect waves-light btn-edit'><i class='fa fa-edit'></i></a>");
                            if (USER_CAN_VIEW == 1) buttons.push("<a href='" + APP_URL + "/" + id + "' data-id='" + id + "' class='btn btn-info btn-sm waves-effect waves-light btn-detail'><i class='fa fa-search'></i></a>");
                            if (USER_CAN_DELETE == 1 && approved == 0) buttons.push("<a href='javascript:void(0);' data-id='" + id + "' class='btn btn-danger btn-sm waves-effect waves-light btn-remove'><i class='fa fa-trash'></i></a>");
                        }
                        return buttons.join("&nbsp;");
                    }
                },
            ]
        };

        appDataTable.render(renderConfig);
    }

    var dataTableApproval = function() {
        let route = "employee_travels";
        let renderConfig = {
            "postData": [{
                    "name": "employee_id",
                    "value": employee_id
                },
                {
                    "name": "manager_id",
                    "value": manager_id
                },
                {
                    "name": "mode",
                    "value": 1
                }
            ],
            "table": "#table-approve",
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
                    "data": "employee_number",
                },
                {
                    "targets": 2,
                    "data": "employee_name",
                },
                {
                    "targets": 3,
                    "data": "destination",
                    "render": function(data, type, row, meta) {
                        return parseInt(data) === 1 ? "Dalam Negeri" : "Luar Negeri";
                    }
                },
                {
                    "targets": 4,
                    "data": "request_date",
                },
                {
                    "targets": 5,
                    "data": "start_date",
                },
                {
                    "targets": 6,
                    "data": "end_date",
                },
                {
                    "targets": 7,
                    "data": "reason",
                },
                {
                    "targets": 8,
                    "data": "is_approved",
                    "render": function(data, type, row, meta) {
                        return getStatus(data);
                    }
                },
                {
                    "targets": 9,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        var buttons = new Array();
                        var APP_URL = BASE_URL + "/submission/employee_travels";
                        var approved = parseInt(row.is_approved);
                        var id = row.id;
                        buttons.push("<textarea data-id='" + id + "' class='hidden item'>" + JSON.stringify(row) + "</textarea>");
                        if (parseInt(approved) > 0) {
                            if (USER_CAN_VIEW == 1) buttons.push("<a href='" + APP_URL + "/" + id + "' data-id='" + id + "' class='btn btn-info btn-sm waves-effect waves-light btn-detail'><i class='fa fa-search'></i></a>");
                        } else {
                            if (USER_CAN_VIEW == 1 && approved == 0) buttons.push("<a href='" + APP_URL + "/" + id + "' data-id='" + id + "' class='btn btn-primary btn-sm waves-effect waves-light btn-approve'><i class='fa fa-gavel'></i></a>");
                        }
                        return buttons.join("&nbsp;");
                    }
                },
            ]
        };

        appDataTable.render(renderConfig);
    }

    $("body").on("click", ".btn-approve", function(e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        let item = $(".item[data-id='" + id + "']").val();
        let json = JSON.parse(item);
        console.log(json);
        let type = parseInt(json.destination);
        if (parseInt(type) === 1) {
            $("#_destinasi").val("Dalam Negeri");
            $("#_provinsi").val(json.province_name);
            $("#_kota").val(json.regency_name);
            $(".foreign").hide();
            $(".domestic").show();
        } else {
            $("#_destinasi").val("Luar Negeri");
            $("#_negara").val(json.country_name);
            $(".foreign").show();
            $(".domestic").hide();
        }
        $("#eid").val(id);
        $("#_provinsi").val(json.province_name);
        $("#_kota").val(json.regency_name);
        $("#_no_pegawai").val(json.employee_number);
        $("#_nama_pegawai").val(json.employee_name);
        $("#_divisi").val(json.division_name);
        $("#_posisi").val(json.position_name);
        $("#_tgl_mohon").val(json.request_date);
        $("#_tgl_mulai").val(json.start_date);
        $("#_tgl_akhir").val(json.end_date);
        $("#_alasan").val(json.reason);
        $("#_biaya").val(numberFormat(json.cost, 2, ",", "."));
        $("#manager_notes").val("");
        $("#myModal").modal("show");
        return false;
    });

    $("body").on("click", ".btn-submit-approve", function(e) {
        e.preventDefault();
        let is_approved = $(this).attr("data-value");
        $("#is_approved").val(is_approved);
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

    if ($('#cost').length) {
        $('#cost').mask('#.##0,00', {
            reverse: true
        });
    }

    if ($(".destination").length) {
        $(".destination").change(function(e) {
            e.preventDefault();
            let type = $(this).val();
            let checked = $(this).is(":checked");
            $("#regency_id").val(null).trigger('change');
            $("#province_id").val(null).trigger('change');
            $("#country_id").val(null).trigger('change');
            if (checked) {
                if (parseInt(type) === 1) {
                    $(".foreign").hide();
                    $(".domestic").show();
                } else {
                    $(".foreign").show();
                    $(".domestic").hide();
                }
            }
            return false;
        });
    }

    if ($(".is_edit").length) {
        let type = $("input[name='destination']:checked").val();
        if (parseInt(type) === 1) {
            $(".foreign").hide();
            $(".domestic").show();
        } else {
            $(".foreign").show();
            $(".domestic").hide();
        }
    }

    if ($(".notif").length) {
        let textNotif = $(".notif").text();
        if ($(".notif_travel").length) {
            $(".notif_travel").removeClass("hidden").text(textNotif);
        }
    }

    dataTableHistory();
    dataTableApproval();

});