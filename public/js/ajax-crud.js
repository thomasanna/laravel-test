var form;
var timeOut = 1000;
var scrollTop = 2000;

$(document).ready(function () {
    $('.data-table-container').each(function () {
        var formValue;
        var columns;
        var length;
        var form;
        var url;
        var table;
        table = $(this).find('.data-tables');
        url = table.data('url');
        form = table.data('form');
        length = table.data('length');
        columns = [];
        formValue = [];
        table.find('thead th').each(function () {
            var column = {'data': $(this).data('column')};
            columns.push(column);
        });
        table.DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            bLengthChange: false,
            pageLength: length,
            ajax: {
                "type": "GET",
                "url": url,
                "data": function (data) {
                    data.form = formValue;
                }
            },
            columns: columns,
            fnDrawCallback: function () {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });
        $('#' + form + '-button').click(function () {
            formValue = $('#' + form + '-form').serializeArray();
            table.DataTable().draw();
        });
        $(document).on('keypress', function (e) {
            if (e.which == 13) {
                e.preventDefault();
                formValue = $('#' + form + '-form').serializeArray();
                table.DataTable().draw();
            }
        });
    });
});

$("body").on("submit", ".ajax-submit", function (e) {
    var field;
    e.preventDefault();
    field = this.id;
    form = $('#' + field);
    $('.error').hide();
    var formData = new FormData($(this)[0]);
    $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: formData,
        processData: false,
        contentType: false,
        // data: form.serialize(),
        success: ajaxSuccess,
        error: ajaxError
    });
});

function ajaxSuccess(html) {
    if (html.error === false) {
        showSuccess(html.message);
        if (html.url && html.url != '') {
            window.location.href = html.url;
        }
    } else {
        showError(html.message);
    }
}

function ajaxError(html) {
    var msg;
    if (html.status === 422) {
        var errors = html.responseJSON.errors;
        var i = 1;
        $.each(errors, function (key, value) {
            $("input[name=" + key + "]").addClass('is-invalid');
            var id = "#" + key + "_error";
            $(id).html(value);
            $(id).show();
        });
        $(".form-control").keyup(function () {
            $(this).closest(".error").hide();
        });
        msg = "Sorry, looks like there are some errors detected, please try again.";
    } else if (html.status === 403) {
        msg = "User not authorised";
    } else {
        msg = "Some thing went wrong, Please try Again";
    }
    showError(msg);
}


function ajaxDelete(id) {
    swal.fire({
        title: "Are you sure?",
        text: "Delete this item",
        buttonsStyling: !1,
        confirmButtonText: "Delete",
        showCancelButton: true,
        customClass: {
            confirmButton: "btn font-weight-bold btn-light-primary",
            cancelButton: "btn font-weight-bold btn-light-danger",
        }
    }).then((function (t) {
        if (t.value) {
            $.ajax({
                url: link + "/" + id,
                type: "DELETE",
                dataType: "html",
                success: dataRefresh,
                error: showError
            });
        }
    }));
}


function dataRefresh(a) {
    var data = JSON.parse(a);
    if (data.error === true) {
        showError(data.message);
    } else {
        $('.data-tables').DataTable().ajax.reload(null, false);
        showSuccess(data.message);
    }
}

function showError(msg) {
    Swal.fire({
        text: msg,
        icon: "error",
        buttonsStyling: false,
        confirmButtonText: "Ok, got it!",
        customClass: {
            confirmButton: "btn font-weight-bold btn-light"
        }
    }).then(function () {
    });
}

function showSuccess(msg) {
    Swal.fire({
        text: msg,
        icon: "success",
        buttonsStyling: false,
        confirmButtonText: "Ok!",
        customClass: {
            confirmButton: "btn font-weight-bold btn-light"
        }
    }).then(function () {
    });
}
