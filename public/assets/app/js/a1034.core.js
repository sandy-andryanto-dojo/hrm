const BASE_URL = $('meta[name="base-url"]').attr('content');
const API_TOKEN = $('meta[name="api-token"]').attr('content');
const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
const USER_CAN_CREATE = $('meta[name="can_add"]').length > 0 ? parseInt($('meta[name="can_add"]').attr('content')) : 0;
const USER_CAN_UPDATE = $('meta[name="can_edit"]').length > 0 ? parseInt($('meta[name="can_edit"]').attr('content')) : 0;
const USER_CAN_DELETE = $('meta[name="can_delete"]').length > 0 ? parseInt($('meta[name="can_delete"]').attr('content')) : 0;
const USER_CAN_VIEW = $('meta[name="can_view"]').length > 0 ? parseInt($('meta[name="can_view"]').attr('content')) : 0;

moment.locale($("html").attr("lang"));



jQuery.browser = {};
(function() {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();

var browser = function() {
    var ua = navigator.userAgent,
        tem, M = ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
    if (/trident/i.test(M[1])) {
        tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
        return {
            name: 'IE',
            version: (tem[1] || '')
        };
    }
    if (M[1] === 'Chrome') {
        tem = ua.match(/\bOPR|Edge\/(\d+)/)
        if (tem != null) {
            return {
                name: 'Opera',
                version: tem[1]
            };
        }
    }
    M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
    if ((tem = ua.match(/version\/(\d+)/i)) != null) {
        M.splice(1, 1, tem[1]);
    }
    return {
        name: M[0],
        version: M[1]
    };
}

var jsonToString = function(data) {
    var encoded = JSON.stringify(data);
    encoded = encoded.replace(/\\"/g, '"')
        .replace(/([\{|:|,])(?:[\s]*)(")/g, "$1'")
        .replace(/(?:[\s]*)(?:")([\}|,|:])/g, "'$1")
        .replace(/([^\{|:|,])(?:')([^\}|,|:])/g, "$1\\'$2");
    return encoded;
};

var stringToJson = function(input) {
    var result = [];

    //replace leading and trailing [], if present
    input = input.replace(/^\[/, '');
    input = input.replace(/\]$/, '');

    //change the delimiter to 
    input = input.replace(/},{/g, '};;;{');

    // preserve newlines, etc - use valid JSON
    //https://stackoverflow.com/questions/14432165/uncaught-syntaxerror-unexpected-token-with-json-parse
    input = input.replace(/\\n/g, "\\n")
        .replace(/\\'/g, "\\'")
        .replace(/\\"/g, '\\"')
        .replace(/\\&/g, "\\&")
        .replace(/\\r/g, "\\r")
        .replace(/\\t/g, "\\t")
        .replace(/\\b/g, "\\b")
        .replace(/\\f/g, "\\f");
    // remove non-printable and other non-valid JSON chars
    input = input.replace(/[\u0000-\u0019]+/g, "");

    input = input.split(';;;');

    input.forEach(function(element) {
        // console.log(JSON.stringify(element));

        result.push(JSON.parse(element));
    }, this);

    return result;
}

var getRandomInt = function(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

var arrayDistinct = function(arr) {
    let unique_array = []
    for (let i = 0; i < arr.length; i++) {
        if (unique_array.indexOf(arr[i]) == -1) {
            unique_array.push(arr[i])
        }
    }
    return unique_array
}

var timeStamp = function() {
    var timeStampInMs = window.performance && window.performance.now && window.performance.timing && window.performance.timing.navigationStart ? window.performance.now() + window.performance.timing.navigationStart : Date.now();
    return Math.floor(timeStampInMs);
}

var fileSizeInfo = function(bytes, si) {
    var thresh = si ? 1000 : 1024;
    if (Math.abs(bytes) < thresh) {
        return bytes + ' B';
    }
    var units = si ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
    var u = -1;
    do {
        bytes /= thresh;
        ++u;
    } while (Math.abs(bytes) >= thresh && u < units.length - 1);
    return bytes.toFixed(1) + ' ' + units[u];
}

var numberFormat = function(number, decimals, dec_point, thousands_sep) {
    // http://kevin.vanzonneveld.net
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +   improved by: davook
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Jay Klehr
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +   improved by: Drew Noakes
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        toFixedFix = function(n, prec) {
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            var k = Math.pow(10, prec);
            return Math.round(n * k) / k;
        },
        s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}


var headerRequest = function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': 'Bearer ' + API_TOKEN,
        }
    });
}

var appDataTable = {
    "render": function(option) {

        $(option.table).dataTable({
            'responsive': true,
            'sPaginationType': 'full_numbers',
            'bServerSide': true,
            'bProcessing': true,
            'sAjaxSource': BASE_URL + "/api/datatable/" + option.route,
            "bLengthChange": true,
            "bFilter": true,
            "bSort": true,
            "bInfo": true,
            "bAutoWidth": true,
            "showNEntries": true,
            'fnServerData': function(sSource, aoData, fnCallback) {
                if (option.postData) {
                    option.postData.forEach(function(row) {
                        aoData.push({
                            name: row.name,
                            value: row.value
                        });
                    });
                }
                headerRequest();
                $.ajax({
                    'dataType': 'json',
                    'type': option.request || "GET",
                    'url': sSource,
                    'data': aoData,
                    'success': fnCallback
                });
            },
            "columns": option.column,
            "order": option.order || [
                [0, "DESC"]
            ],
            "createdRow": option.createdRow,
            "footerCallback": option.footerCallback,
            "language": {
                "sEmptyTable": "Tidak ada data yang tersedia pada tabel ini",
                "sProcessing": "Sedang memproses...",
                "sLengthMenu": "Tampilkan _MENU_ entri",
                "sZeroRecords": "Tidak ditemukan data yang sesuai",
                "sInfo": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "sInfoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                "sInfoPostFix": "",
                "sSearch": "Cari:",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext": "Selanjutnya",
                    "sLast": "Terakhir"
                }
            }
        });

        //$("select[name='table_length']").addClass("from-control").select2();



        var t = $(option.table).dataTable();

        $("body").on("click", ".btn-remove", function(e) {
            e.preventDefault();
            var id = $(this).attr("data-id");
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
                        url: BASE_URL + "/api/destroy/" + option.route + "/" + id,
                        success: function(data) {
                            swal.close();
                            showToast({
                                "title": "Proses Sukses",
                                "message": "Data Berhasil Di Hapus !!",
                                "mode": "success"
                            });
                            t.fnClearTable();
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            });
            return false;
        });


    },
    "action": function(route, id, prefixAction) {
        var buttons = new Array();
        var APP_URL = BASE_URL;
        if (prefixAction) {
            APP_URL = BASE_URL + "/" + prefixAction + "/" + route;
        } else {
            APP_URL = BASE_URL + "/" + route;
        }

        if (USER_CAN_UPDATE == 1) buttons.push("<a href='" + APP_URL + "/" + id + "/edit' class='btn btn-primary btn-sm waves-effect waves-light btn-edit'><i class='fa fa-edit'></i></a>");
        if (USER_CAN_VIEW == 1) buttons.push("<a href='" + APP_URL + "/" + id + "' class='btn btn-info btn-sm waves-effect waves-light btn-detail'><i class='fa fa-search'></i></a>");
        if (USER_CAN_DELETE == 1) buttons.push("<a href='javascript:void(0);' data-id='" + id + "' class='btn btn-danger btn-sm waves-effect waves-light btn-remove'><i class='fa fa-trash'></i></a>");
        return buttons.join("&nbsp;");
    }
};

var slug = function(str) {
    var $slug = '';
    var trimmed = $.trim(str);
    $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
    replace(/-+/g, '-').
    replace(/^-|-$/g, '');
    return $slug.toLowerCase();
}

var ucFirst = function(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

var showToast = function(option) {
    var title = option.title;
    var message = option.message;
    var mode = option.mode;
    if (mode == 'warning') {
        toastr.warning(message, title);
    } else if (mode == 'success') {
        toastr.success(message, title);
    } else if (mode == 'error') {
        toastr.error(message, title);
    } else if (info == 'info') {
        toastr.info(message, title);
    }

}

var tableLabelStatus = function(label, text) {
    return '<span class="label label-' + label + '">' + text + '</span></td>';
}

var getNotification = function() {
    headerRequest();
    $.post(BASE_URL + "/api/notifications", function(result) {
        if (result) {
            if ($(".text-read").length) {
                $(".text-read").text(result.totalRead);
            }
            if ($(".text-unread").length) {
                $(".text-unread").text(result.totalUnRead);
            }
            let list = result.list;
            let template = $("#template-notif");
            $(".list-notification").removeClass("hidden");
            $("#list-notification").empty();
            $("#list-notification").append("<li><h5><strong>Pemberitahuan</strong></h5></li>");
            if (list.length > 0) {
                list.forEach(function(row) {
                    template.find(".user-list-item").attr("href", BASE_URL + "/settings/notifications/" + row.id);
                    template.find(".user-desc").find(".name").text(row.subject);
                    template.find(".user-desc").find(".time").text(row.first_name + " " + row.last_name + " | " + row.created_at);
                    $("#list-notification").append(template.html());
                });
            } else {
                template.find(".user-list-item").attr("href", BASE_URL + "/settings/notifications");
                template.find(".user-desc").find(".name").text("Tidak ada pesan terbaru");
                template.find(".user-desc").find(".time").text("-");
                $("#list-notification").append(template.html());
            }
            $("#list-notification").append("<li class='all-msgs text-center'><p class='m-0'><a href='" + BASE_URL + "/settings/notifications'>Lihat Semua Pemberitahuan</a></p></li>");

        }
    });
}

$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

    $("body").on("click", ".btn-delete", function(e) {
        e.preventDefault();
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
                $("#form-delete").submit();
            }
        });
        return false;
    });




    if ($(".select2").length > 0) {
        $(".select2").select2();
    }

    if ($(".input-datepicker").length) {
        $(".input-datepicker").datepicker({
            autoclose: true,
            clearBtn: true,
            format: 'yyyy-mm-dd',
            language: "id",
            orientation: "bottom"
        });
    }

    if ($(".datetime-picker").length) {
        $('.datetime-picker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: "id"
        });
    }

    if ($(".file-input-image").length) {
        $(".file-input-image").filer({
            showUpload: false,
            allowedFileExtensions: ["jpg", "png", "gif"],
            maxFileCount: 1,
        });
    }

    if ($(".file-input-lampiran").length) {
        $(".file-input-lampiran").filer({
            limit: 1,
            maxSize: 4,
            extensions: ['jpg', 'jpeg', 'png', 'pdf'],
            changeInput: true,
            showThumbs: true,
            addMore: false
        });
    }

    if ($(".input-hour").length) {
        $('.input-hour').clockpicker({
            donetext: 'Selesai',
            autoclose: true,
            default: 'now',
            align: 'left'
        });
    }

    if ($(".summernote").length) {
        $('.summernote').summernote({
            height: 350, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });

    }

    if ($(".filestyle").length) {
        $(".filestyle").filestyle({ input: false });
    }

    if (parseInt(USER_CAN_CREATE) == 0) {
        $(".btn-create-data").hide();
    }

    if (parseInt(USER_CAN_VIEW) == 0) {
        $(".btn-detail").hide();
    }

    if (parseInt(USER_CAN_DELETE) == 0) {
        $(".btn-remove-data").hide();
    }

    if (parseInt(USER_CAN_UPDATE) == 0) {
        $(".btn-edit-data").hide();
    }

    $("body").on("click", ".btn-logout", function(e) {
        e.preventDefault();
        swal({
            title: "",
            text: "Apakah anda yakin keluar dari aplikasi ?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            confirmButtonColor: "#ec6c62"
        }, function() {
            $("#logout-form").unbind('submit').submit();
        });
        return false;
    });

    getNotification();

});