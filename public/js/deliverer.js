$(function () {
    $("#delivererForm").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email: {
                required: true
            },
            phone: {
                required: true
            }
        },
        submitHandler: function (form) {
            saveDeliverer()
        }
    });
})

// Add deliverers
function saveDeliverer() {
    var delivererData = new FormData(document.getElementById('delivererForm'));

    $.ajax({
        url: baseURL + '/deliverers',
        type: 'POST',
        processData: false,
        contentType: false,
        data: delivererData,
        success: function (response) {
            if (response.status == 200) {
                var id = response.data.id

                var html = '<tr id="ing-tr'+ id +'">' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               data-id="' + id + '"' +
                    '                               value="' + response.data.first_name + '"' +
                    '                               id="first_name' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               value="' + response.data.last_name + '"' +
                    '                               id="last_name' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               value="' + response.data.phone + '"' +
                    '                               id="phone' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               value="' + response.data.email + '"' +
                    '                               id="email' + id + '"' +
                    '                               readonly/>' +
                    '<td class="text-center"> <div class="form-check form-switch custom-switch justify-content-center ps-0">' +
                    '<input type="checkbox" role="switch" class="form-check-input" checked' +
                    '                               id="deliverer_status__' + id + '"' +
                    '                               onchange="changeDelivererStatus("' + response.data.id + '")"readonly/>' +
                    '</div>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '    <div class="d-flex flex-nowrap gap-2">' +
                    '        <a class="btn btn-site-theme btn-icon edit-deliverer-icon"' +
                    '           id="edit-btn' + id + '"' +
                    '           data-id="' + id + '" tabindex="0">' +
                    '            <i class="fa-solid fa-pen-to-square"></i>' +
                    '        </a>' +
                    '        <a class="btn btn-site-theme btn-icon del-deliverer-icon"' +
                    '           id="del-btn' + id + '"' +
                    '           data-bs-toggle="modal" data-id="' + id + '"' +
                    '           data-bs-target="#deleteAlertModal">' +
                    '            <i class="fa-regular fa-trash-can"></i>' +
                    '        </a>' +
                    '        <a class="btn btn-site-theme btn-default save-edit-btn d-block"' +
                    '           id="save-edit-btn' + id + '"' +
                    '           style="width: auto;margin-left: 0%; display: none!important;"' +
                    '           data-id="' + id + '">' +
                    '            <span class="align-middle">'+ dishValidation.save_btn +'</span>' +
                    '        </a>' +
                    '    </div>' +
                    '</td>' +
                    '</tr>';
                $('#delivererTbody').prepend(html)
                $('#delivererForm').trigger('reset')

                toastr.success(response.message)

            }else{
                toastr.error(response.message)
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
}

// Edit deliverers
$(document).on('click', '.edit-deliverer-icon', function () {
    var id = $(this).attr('data-id')
    console.log("id", id)
    $(this).parent().parent().siblings().children('input').attr("readonly", false).focus();
    $('#save-edit-btn' + id).show()
    $('#edit-btn' + id).hide()
    $('#del-btn' + id).hide()
})

// show delete deliverers model
$(document).on('click', '.del-deliverer-icon', function () {

    var id = $(this).attr('data-id');
    $('#catId').val(id)
    $('#deleteAlertModal').modal('show')
})

// deliverers update
$(document).on('click', '.save-edit-btn', function () {
    var id = $(this).attr('data-id')

    var first_name = $('#first_name' + id).val();
    var last_name = $('#last_name' + id).val();
    var phone = $('#phone' + id).val();
    var email = $('#email' + id).val();

    if (first_name == '') {
        $('#first_name' + id).focus();
        return false;
    }

    if (last_name == '') {
        $('#last_name' + id).focus();
        return false;
    }

    if (phone == '') {
        $('#phone' + id).focus();
        return false;
    }
    if (email == '') {
        $('#email' + id).focus();
        return false;
    }

    $.ajax({
        url: baseURL + '/deliverers/' + id,
        type: 'PUT',
        data: {
            first_name,
            last_name,
            phone,
            email,
        },
        success: function (response) {
            console.log(response.data)
            if (response.status == 200) {
                $('#first_name'+id).prop('readonly', true)
                $('#last_name'+id).prop('readonly', true)
                $('#phone'+id).prop('readonly', true)
                $('#email'+id).prop('readonly', true)
                $('#edit-btn'+id).show()
                $('#del-btn'+id).show()
                $('#save-edit-btn'+id).attr('style','width: 50%;margin-left: 25%; display: none!important; !important')
                toastr.success(response.message)
            } else {
                toastr.error(response.message)
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })

})

// deliverers status change
function changeDelivererStatus(id) {
    var status = $("#deliverer_status_" + id).prop('checked') == true ? 1 : 0;

    $.ajax({
        url: '/deliverers/status-change',
        type: 'POST',
        data: {
            id, status
        },
        success: function (response) {
            toastr.success(response.message)
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

// deliverers delete
$(document).on('click', '#delete-deliverer-btn', function () {

    var id = $('#catId').val();

    $.ajax({
        url: baseURL + '/deliverers/' + id,
        type: 'DELETE',
        success: function (response) {
            $('#deliverer-tr'+id).remove();
            $('#deleteAlertModal').modal('hide')
            toastr.success(response.message)

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
})

// function saveDeliverer(id) {
//     $('#zipcode-save-btn').prop('disabled', true);
//
//     var first_name = $('#first_name_' + id).val();
//     var last_name = $('#last_name_' + id).val();
//     var phone = $('#phone_' + id).val();
//     var email = $('#email_' + id).val();
//     var status = $('#status_' + id).is(':checked') == true ? '1' : '0';
//
//     console.log("first_name", first_name)
//     if (first_name == '') {
//         $('#first_name_' + id).focus();
//         return false;
//     }
//
//     if (last_name == '') {
//         $('#last_name_' + id).focus();
//         return false;
//     }
//
//     if (phone == '') {
//         $('#phone_' + id).focus();
//         return false;
//     }
//     if (email == '') {
//         $('#email_' + id).focus();
//         return false;
//     }
//
//     $.ajax({
//         url: '/save-deliverers',
//         type: 'POST',
//         data: {
//             id, first_name, last_name, phone, email, status
//         },
//         success: function (response) {
//             if (id != 0 || id != '') {
//                 $('.deliverer-row-' + id).find('input').attr('readonly', true);
//                 $("#deliverer-remove-btn-" + id).show();
//                 $("#deliverer-edit-btn-" + id).show();
//                 $("#deliverer-save-btn-" + id).css("display", "none");
//                 toastr.success(response.message)
//             } else {
//                 $('#first_name_0').val('');
//                 $('#last_name_0').val('');
//                 $('#phone_0').val('');
//                 $('#email_0').val('');
//
//                 $('.deliverer-row-0').after(response.data);
//
//                 toastr.success(response.message)
//             }
//         },
//         error: function (response) {
//             var errorMessage = JSON.parse(response.responseText).message
//             alert(errorMessage);
//         }
//     })
// }
// function editDeliverer(id) {
//     $('.deliverer-row-' + id).find('input').removeAttr('readonly');
//     $('#id').val(id);
//
//     $("#deliverer-remove-btn-" + id).hide();
//     $("#deliverer-edit-btn-" + id).hide();
//     $("#deliverer-save-btn-" + id).css("display", "block");
// }
//
// function deleteDeliverer(id) {
//     $('#id').val(id);
//     $('#deleteDelivererModal').modal('show');
// }
