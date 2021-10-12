$(document).ready(function() {

    var route = "workers";
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
                "data": "username",
            },
            {
                "targets": 4,
                "data": "email",
            },
            {
                "targets": 5,
                "data": "division_name",
            },
            {
                "targets": 6,
                "data": "position_name",
            },
            {
                "targets": 7,
                "data": "type_name",
            },
            {
                "targets": 8,
                "data": "join_date",
            },
            {
                "targets": 9,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    return appDataTable.action(route, row.id, "employees");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    $("#FormSubmit").submit(function(e) {
        e.preventDefault();
        swal({
            title: "Konfirmasi Simpan",
            text: "Apakah anda data pegawai yang diisi sudah benar ?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonColor: "#ec6c62"
        }, function() {
            $("#FormSubmit").unbind('submit').submit();
        });
        return false;
    });

    $("body").on("click", ".btn-hapus", function(e) {
        e.preventDefault();
        let eid = $(this).attr("data-id");
        swal({
            title: "Konfirmasi Hapus",
            text: "Apakan anda yakin akan menghapus lampiran / dokumen ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f8b32d",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                $("#eid").val(eid);
                $("#form-delete-attachment").submit();
            }
        });
        return false;
    });


});