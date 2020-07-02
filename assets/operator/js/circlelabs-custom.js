
// notif toastr
var notif = {
    // toastr["success"]("Are you the six figured man?")

    success : function(message = "default text", header = "default header"){
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: false,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null
        };
        toastr["success"](message, header)
    },
    info : function(message = "default text", header = "default header"){
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: false,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null
        };
        toastr["info"](message, header)
    },
    warning : function(message = "default text", header = "default header"){
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: false,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null
        };
        toastr["warning"](message, header)
    },
    error : function(message = "default error text", header = "default error header"){
        toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: false,
            positionClass: 'toast-top-right',
            preventDuplicates: false,
            onclick: null
        };
        toastr["error"](message, header)
    },
}

// alert ajax
var alertajax = {
    error : function(textStatus = "Error", codeStatus = "000"){
        $.alert({
            title: 'Eror!',
            type: 'red',
            content: 'Terjadi kesalahan saat menghubungkan ke server! Kode : ' +textStatus+' '+codeStatus,
        });
    }
}

// Datatable setup
/* Datatable Dom */
var dom_full = "<'row m-b-20'<'col-lg-2 col-sm-12 col-xs-12 col-md-12'>>" +
"<'row'<'col-sm-12 col-lg-12'tr>>" +
"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
// var dom_full =
//     "<'#myTable_filter.dataTables_filter'f>r" + '<"top">rt<"clear">'
//     "t" +
//     "<'#tbrand_info.dataTables_info'i><'#tbrand_paginate.dataTables_paginate paging_simple_numbers'p>";

var dom_footer = "" + "t" + "<'#tbrand_info.dataTables_info'i><'#tbrand_paginate.dataTables_paginate paging_simple_numbers'p>";
var dom_only_table = "" + "t" + "<'row'<'col col-sm-6 col-xs-12 hidden-xs'><'col-xs-12 col-sm-6'>r>";
var dom_none = "" + "t" + "<'row p-0'<'col col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>r>";

function only_number(id, length) {

    $(id).inputmask("decimal", {
        placeholder: '',
        autoUnmask: true,
        groupSeparator: ",",
        autoGroup: true,
        rightAlign: false,
        integerDigits: length,
    })

}
