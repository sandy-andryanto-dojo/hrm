var id = $("#id");
var school_name = $("#school_name");
var qualification_id = $("#qualification_id");
var department = $("#department");
var specliationation = $("#specliationation");
var country_id = $("#country_id");
var score = $("#score");
var scale = $("#scale");
var month_start = $("#month_start");
var year_start = $("#year_start");
var month_end = $("#month_end");
var year_end = $("#year_end");

var resetForm = function() {
    var d = new Date();
    var n = d.getFullYear();
    id.val("");
    school_name.val("");
    qualification_id.val(null).trigger('change');
    department.val("");
    specliationation.val("");
    country_id.val(null).trigger('change');
    score = $("#score");
    scale = $("#scale");
    month_start.val(null).trigger('change');
    year_start.val(n);
    month_end.val(null).trigger('change');
    year_end.val(n);
}

$(document).ready(function() {

    // Tambah Data
    $(".btn-create-data").click(function(e) {
        e.preventDefault();
        resetForm();
        $("#myModal").modal("show");
        return false;
    });

    // Ubah Data
    $("body").on("click", ".btn-ubah", function(e) {
        e.preventDefault();
        resetForm();
        let rowId = $(this).attr("data-id");
        let item = $("#item" + rowId).val();
        let data = JSON.parse(item);
        console.log(data);
        id.val(data.id);
        school_name.val(data.school_name);
        qualification_id.val(data.qualification_id).trigger('change');
        department.val(data.department);
        specliationation.val(data.specliationation);
        country_id.val(data.country_id).trigger('change');
        score.val(data.score);
        scale.val(data.score);
        month_start.val(data.month_start).trigger('change');
        year_start.val(data.year_start);
        month_end.val(data.month_end).trigger('change');
        year_end.val(data.year_end);
        $("#myModal").modal("show");
        return false;
    });

    // Hapus Data
    $("body").on("click", ".btn-hapus", function(e) {
        e.preventDefault();
        resetForm();
        let rowId = $(this).attr("data-id");
        let item = $("#item" + rowId).val();
        let data = JSON.parse(item);
        let eid = data.id;
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
                $("#eid").val(eid);
                $("#form-delete").submit();
            }
        });
        return false;
    });

});