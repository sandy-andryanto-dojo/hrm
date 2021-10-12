$(document).ready(function() {

    var dataTable = function(table, read) {
        let route = "notifications";
        let renderConfig = {
            "postData": [{
                "name": "is_read",
                "value": read
            }, ],
            "table": table,
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
                    "data": "created_at"
                },
                {
                    "targets": 2,
                    "data": "subject",
                },
                {
                    "targets": 3,
                    "data": "sender",
                },
                {
                    "targets": 4,
                    "data": "content",
                },
                {
                    "targets": 5,
                    "orderable": false,
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        var buttons = new Array();
                        var APP_URL = BASE_URL + "/settings/" + route;
                        var id = row.id;
                        buttons.push("<a href='" + APP_URL + "/" + id + "' class='btn btn-info btn-sm waves-effect waves-light btn-detail'><i class='fa fa-search'></i></a>");
                        buttons.push("<a href='javascript:void(0);' data-id='" + id + "' data-table='" + table + "' class='btn btn-danger btn-sm waves-effect waves-light btn-remove-notif'><i class='fa fa-trash'></i></a>");
                        return buttons.join("&nbsp;");
                    }
                },
            ]
        };

        appDataTable.render(renderConfig);
    }

    $("body").on("click", ".btn-remove-notif", function(e) {
        e.preventDefault();
        var id = $(this).attr("data-id");
        var table = $(this).attr("data-table");
        swal({
            title: "Konfirmasi Hapus",
            text: "Apakan anda yakin akan menghapus data ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#f8b32d",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm) {
                headerRequest();
                $.ajax({
                    type: "DELETE",
                    url: BASE_URL + "/api/destroy/notifications/" + id,
                    success: function(data) {
                        swal.close();
                        showToast({
                            "title": "Proses Sukses",
                            "message": "Data Berhasil Di Hapus !!",
                            "mode": "success"
                        });
                        var t = $(table).dataTable();
                        t.fnClearTable();
                        getNotification();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        });
        return false;
    });


    dataTable("#table1", 1);
    dataTable("#table2", 0);

});