$(document).ready(function() {

    var employee_id = $("#employee_id").text();
    var manager_id = $("#manager_id").text();

    var getAnnualStatus = function(status) {
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
        let route = "employee_loans";
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
                    "data": "cost",
                    "render": function(data, type, row, meta) {
                        return numberFormat(data, 2, ",", ".");
                    }
                },
                {
                    "targets": 2,
                    "data": "reason"
                },
                {
                    "targets": 3,
                    "data": "is_approved",
                    "render": function(data, type, row, meta) {
                        return getAnnualStatus(data);
                    }
                },
                {
                    "targets": 4,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        var buttons = new Array();
                        var APP_URL = BASE_URL + "/submission/employee_over_times";
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

    var datatableApproval = function() {
        let route = "employee_loans";
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
                    "data": "cost",
                    "render": function(data, type, row, meta) {
                        return numberFormat(data, 2, ",", ".");
                    }
                },
                {
                    "targets": 4,
                    "data": "reason"
                },
                {
                    "targets": 5,
                    "data": "is_approved",
                    "render": function(data, type, row, meta) {
                        return getAnnualStatus(data);
                    }
                },
                {
                    "targets": 6,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        var buttons = new Array();
                        var APP_URL = BASE_URL + "/submission/employee_over_times";
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
        $("#eid").val(id);
        $("#_no_pegawai").val(json.employee_number);
        $("#_nama_pegawai").val(json.employee_name);
        $("#_divisi").val(json.division_name);
        $("#_posisi").val(json.position_name);
        $("#_total").val(numberFormat(json.cost, 2, ",", "."));
        $("#_alasan").val(json.reason);
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

    if ($('#cost').length) {
        $('#cost').mask('#.##0,00', {
            reverse: true
        });
    }

    if ($(".notif").length) {
        let textNotif = $(".notif").text();
        if ($(".notif_loan").length) {
            $(".notif_loan").removeClass("hidden").text(textNotif);
        }
    }

    dataTableHistory();
    datatableApproval();

});