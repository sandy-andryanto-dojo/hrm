var id = $("#id");
var skill_name = $("#name");
var level = $("#level");
var description = $("#description");

var resetForm = function() {
    id.val("");
    skill_name.val("");
    level.val(null).trigger('change');
    description.val("");
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
        id.val(data.id);
        skill_name.val(data.name);
        level.val(data.level).trigger('change');
        description.val(data.description);
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