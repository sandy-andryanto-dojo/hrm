$(document).ready(function() {

    var calculateHour = function() {
        var total = 0;
        $("input.total").each(function() {
            let i_total = parseInt($(this).val()) || 0;
            total = total + i_total;
        });
        $("#total_hadir").text(total);
    }

    var month = $("#table").attr("data-month");
    var year = $("#table").attr("data-year");
    var route = "employee_absences/" + month + "/" + year;
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
                "data": "nik",
                "orderable": false,
            },
            {
                "targets": 2,
                "data": "employee_name",
                "orderable": false,
            },
            {
                "targets": 3,
                "data": "division_name",
                "orderable": false,
            },
            {
                "targets": 4,
                "data": "position_name",
                "orderable": false,
            },
            {
                "targets": 5,
                "data": "total_absence",
                "orderable": false,
            },
            {
                "targets": 6,
                "data": "employee_id",
                "orderable": false,
                "render": function(data, type, row, meta) {
                    let id = data;
                    var buttons = new Array();
                    buttons[0] = "<a href='" + BASE_URL + "/submission/employee_absences/detail/" + month + "/" + year + "/" + id + "' class='btn btn-sm btn-info'><i class='fa fa-search'></i></a>";
                    return buttons.join("&nbsp;");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    $("#btn-filter").click(function(e) {
        e.preventDefault();
        $("#myModal").modal("show");
        return false;
    });


    $("#btn-filter-show").click(function(e) {
        e.preventDefault();
        $("#myModal").modal("show");
        return false;
    });

    $("#form-filter").submit(function(e) {
        e.preventDefault();
        let month = $("#month").val();
        let year = $("#year").val();
        window.location.href = BASE_URL + "/submission/employee_absences/" + month + "/" + year;
        return false;
    });

    $("#form-filter-show").submit(function(e) {
        e.preventDefault();
        let month = $("#month").val();
        let year = $("#year").val();
        let employee_id = $("#employee_id").val();
        window.location.href = BASE_URL + "/submission/employee_absences/detail/" + month + "/" + year + "/" + employee_id;
        return false;
    });

    $("#form-filter-edit").submit(function(e) {
        e.preventDefault();
        let month = $("#month").val();
        let year = $("#year").val();
        let employee_id = $("#employee_id").val();
        window.location.href = BASE_URL + "/submission/employee_absences/modify/" + month + "/" + year + "/" + employee_id;
        return false;
    });


    $("#form-submit").submit(function(e) {
        e.preventDefault();
        var status = true;
        $("select.status").each(function() {
            let i_val = $(this).val();
            let id = $(this).attr("data-id");
            let date_index = $(".date_index[data-id='" + id + "']").text();
            let day_name = $(".day_name[data-id='" + id + "']").text();
            if (!i_val) {
                showToast({
                    "title": "",
                    "message": "Kehadiran tanggal " + date_index + " , hari " + day_name + " harap di isi !!",
                    "mode": "error"
                });
                status = false;
            }
        });

        if (status) {
            swal({
                title: "Konfirmasi Simpan",
                text: "Apakah anda yakin sudah mengisi dengan benar ?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonText: "Ya",
                cancelButtonText: "Tidak",
                confirmButtonColor: "#ec6c62"
            }, function() {
                $("#form-submit").unbind('submit').submit();
            });
        }

        return false;
    });



    $("input.input-hour").change(function(e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        let i_start_hour = $("input.start_hour[data-id='" + id + "']").val();
        let i_end_hour = $("input.end_hour[data-id='" + id + "']").val();
        var start_hour = moment(i_start_hour, 'HH:mm');
        var end_hour = moment(i_end_hour, 'HH:mm');
        if (start_hour > end_hour) {
            $("input.start_hour[data-id='" + id + "']").val("09:00");
            $("input.end_hour[data-id='" + id + "']").val("17:00");
            $("input.total[data-id='" + id + "']").val("8");
        } else {
            let total = end_hour.diff(start_hour, 'hours');
            $("input.total[data-id='" + id + "']").val(total);
        }
        calculateHour();
        return false;
    });

    $("select.status").change(function(e) {
        e.preventDefault();
        let id = $(this).attr("data-id");
        let i_val = $(this).val();
        if (parseInt(i_val) === 0) {
            $("input.start_hour[data-id='" + id + "']").val("09:00");
            $("input.end_hour[data-id='" + id + "']").val("09:00");
            $("input.total[data-id='" + id + "']").val("0");
        } else {
            $("input.start_hour[data-id='" + id + "']").val("09:00");
            $("input.end_hour[data-id='" + id + "']").val("17:00");
            $("input.total[data-id='" + id + "']").val("8");
        }
        calculateHour();
        return false;
    });

    $("#btn-approve").click(function(e) {
        e.preventDefault();
        swal({
            title: "",
            text: "Apakah anda yakin  ?",
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

    calculateHour();

    if ($(".notif").length) {
        let textNotif = $(".notif").text();
        if ($(".notif_absence").length) {
            $(".notif_absence").removeClass("hidden").text(textNotif);
        }
    }

});