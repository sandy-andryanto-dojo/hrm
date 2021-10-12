$(document).ready(function() {

    var route = "vacancies";
    var renderConfig = {
        "postData": [{
            "name": "isAcceptance",
            "value": 1
        }],
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
                "data": "vacancy_name"
            },
            {
                "targets": 2,
                "data": "type_name"
            },
            {
                "targets": 3,
                "data": "job_name"
            },
            {
                "targets": 4,
                "data": "position_name"
            },
            {
                "targets": 5,
                "data": "division_name"
            },
            {
                "targets": 6,
                "data": "start_date"
            },
            {
                "targets": 7,
                "data": "end_date"
            },
            {
                "targets": 8,
                "data": "is_closed",
                "render": function(data, type, row, meta) {
                    return parseInt(data) === 1 ? tableLabelStatus("danger", "Tidak Aktif") : tableLabelStatus("success", "Aktif");
                }
            },
            {
                "targets": 9,
                "data": "total_candidate",
                "orderable": false,
            },
            {
                "targets": 10,
                "orderable": false,
                "className": "text-center",
                "render": function(data, type, row, meta) {
                    var status = parseInt(row.is_closed);
                    var buttons = new Array();
                    var id = row.id;
                    var APP_URL = BASE_URL + "/recruitment/acceptances";
                    var totalCandidate = parseInt(row.total_candidate);
                    var disabled = totalCandidate > 0 ? "" : "disabled";
                    buttons.push("<a href='" + APP_URL + "/" + id + "' class='btn btn-info btn-sm waves-effect waves-light " + disabled + " '><i class='fa fa-search'></i></a>");
                    return buttons.join("&nbsp;");
                }
            },
        ]
    };

    appDataTable.render(renderConfig);

    if ($(".btn-approve").length) {
        $(".btn-approve").click(function(e) {
            e.preventDefault();
            let id = $(this).attr("data-id");
            let status = $(this).attr("data-status");
            let text = $(this).attr("data-text");
            $("#eid").val(id);
            $("#estatus").val(status);
            swal({
                title: "Konfirmasi Persetujuan",
                text: "Apakah anda yakin " + text + " kandidat ini ?",
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
    }

});