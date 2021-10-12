var id = $("#id");
var company_name = $("#company_name");
var position_id = $("#position_id");
var division_id = $("#division_id");
var specliationation_id = $("#specliationation_id");
var industry_id = $("#industry_id");
var country_id = $("#country_id");
var sallary = $("#sallary");
var month_start = $("#month_start");
var year_start = $("#year_start");
var month_end = $("#month_end");
var year_end = $("#year_end");
var currency_id = $("#currency_id");

var resetForm = function() {
    var d = new Date();
    var n = d.getFullYear();
    id.val("");
    company_name.val("");
    position_id.val(null).trigger('change');
    division_id.val(null).trigger('change');
    specliationation_id.val(null).trigger('change');
    industry_id.val(null).trigger('change');
    country_id.val(null).trigger('change');
    sallary.val(numberFormat(0, 2, ",", "."));
    month_start.val(null).trigger('change');
    year_start.val(n);
    month_end.val(null).trigger('change');
    year_end.val(n);
    currency_id.val(null).trigger('change');
}

$(document).ready(function() {

   

    if ($('#sallary').length) {
        $('#sallary').mask('#.##0,00', {
            reverse: true
        });
    }

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
        company_name.val(data.company_name);
        position_id.val(data.position_id).trigger('change');
        division_id.val(data.division_id).trigger('change');
        specliationation_id.val(data.specliationation_id).trigger('change');
        industry_id.val(data.industry_id).trigger('change');
        country_id.val(data.country_id).trigger('change');
        sallary.val(numberFormat(data.sallary, 2, ",", "."));
        month_start.val(data.month_start).trigger('change');
        year_start.val(data.year_start);
        month_end.val(data.month_end).trigger('change');
        year_end.val(data.year_end);
        currency_id.val(data.currency_id).trigger('change');
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
            confirmButtonText: "Yes",
            cancelButtonText: "No",
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