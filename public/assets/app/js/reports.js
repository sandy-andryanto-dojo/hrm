$(document).ready(function() {

    $("body").on("click", ".btn-print", function(e) {
        e.preventDefault();
        let code = $(this).attr("data-code");
        $("#code").val(code);
        if ($(this).hasClass("type1")) {
            $("#myModal").modal("show");
        }
        if ($(this).hasClass("type2")) {
            $("#form-submit").submit();
        }
        return false;
    });

});