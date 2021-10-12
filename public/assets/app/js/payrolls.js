$(document).ready(function() {

    $("#btn-filter").click(function(e) {
        e.preventDefault();
        $("#myModal").modal("show");
        return false;
    });

    $("#form-filter").submit(function(e) {
        e.preventDefault();
        let month = $("#month").val();
        let year = $("#year").val();
        window.location.href = BASE_URL + "/payrolls/" + month + "/" + year;
        return false;
    });

    $("#btn-filter-show").click(function(e) {
        e.preventDefault();
        $("#myModal").modal("show");
        return false;
    });

    $("#form-filter-show").submit(function(e) {
        e.preventDefault();
        let month = $("#month").val();
        let year = $("#year").val();
        let eid = $("#eid").val();
        window.location.href = BASE_URL + "/payrolls/detail/" + month + "/" + year + "/" + eid;
        return false;
    });

    $("body").on("click", "#btn-confirm", function(e) {
        e.preventDefault();
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



    var route = "payrolls";
    var renderConfig = {
        "postData": [{
                "name": "month",
                "value": $("#month").val() || 0
            },
            {
                "name": "year",
                "value": $("#year").val() || 0
            },
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
                "data": "month_salary",
                "render": function(data, type, row, meta) {
                    return numberFormat(data, 2, ",", ".");
                }
            },
            {
                "targets": 7,
                "data": "total_allowances",
                "orderable": false,
                "render": function(data, type, row, meta) {
                    return numberFormat(data, 2, ",", ".");
                }
            },
            {
                "targets": 8,
                "data": "total_cuts",
                "orderable": false,
                "render": function(data, type, row, meta) {
                    return numberFormat(data, 2, ",", ".");
                }
            },
            {
                "targets": 9,
                "data": "take_home",
                "orderable": false,
                "render": function(data, type, row, meta) {
                    return numberFormat(data, 2, ",", ".");
                }
            },
            {
                "targets": 10,
                "data": "status",
                "orderable": false,
                "render": function(data, type, row, meta) {
                    if (parseInt(data) > 0) {
                        return tableLabelStatus("success", "Sudah dikonfirmasi");
                    } else {
                        return tableLabelStatus("danger", "Belum dikonfirmasi");
                    }
                }
            },
            {
                "targets": 11,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    var buttons = new Array();
                    var APP_URL = BASE_URL + "/payrolls";
                    var month = $("#variables").find(".month").text();
                    var year = $("#variables").find(".year").text();
                    var id = month + "/" + year + "/" + row.id;
                    buttons.push("<a href='" + APP_URL + "/detail/" + id + "' class='btn btn-info btn-sm waves-effect waves-light btn-detail'><i class='fa fa-search'></i></a>");
                    buttons.push("<a href='" + APP_URL + "/print/" + id + "' target='_blank' class='btn btn-warning btn-sm waves-effect waves-light btn-detail'><i class='fa fa-print'></i></a>");
                    return buttons.join("&nbsp;");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

});