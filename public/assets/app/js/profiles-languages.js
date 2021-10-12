var id = $("#id");
var language = $("#language");
var i_read = $("#read");
var i_listen = $("#listen");
var i_write = $("#write");
var description = $("#description");

var resetForm = function() {
    id.val("");
    language.val(null).trigger('change');
    i_read.val(0);
    i_listen.val(0);
    i_write.val(0);
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
        language.val(data.language).trigger('change');
        i_read.val(data.read);
        i_listen.val(data.listen);
        i_write.val(data.write);
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