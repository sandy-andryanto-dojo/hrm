$(document).ready(function() {
    // Hapus Data
    $("body").on("click", ".btn-hapus", function(e) {
        e.preventDefault();
        let eid = $(this).attr("data-id");
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