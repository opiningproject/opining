$(function () {
    var url = baseURL + '/user/dashboard';

    $("#delivery-add-form").validate({
        rules:{
            zipcode: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
            house_no: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
        },
        submitHandler: function (form) {
            validateZipcode();
            //window.location.href = url;
        }
    });

    $("#take-away-add-form").validate({
        submitHandler: function (form) {
            // window.location.href = url;
            addTakeawayPhone()
        }
    });

    $("#address-form").validate({
        rules:{
            zipcode: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
            house_no: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
        },
        submitHandler: function (form) {
            validateZipcode()
        }
    });

    $('#addressChangeModal').on('hidden.bs.modal', function () {
        var alertas = $('#address-form');
        alertas.trigger("reset");
        alertas.validate().resetForm();

        $("#zipcode-error").addClass('d-none');
    });

    $(document).on('click', '.select-address-btn', function () {

        var addressId = $(this).data('id')

        $.ajax({
            url: baseURL + '/user/validate-address/' + addressId,
            type: 'GET',
            success: function (response) {
                $('#zipcode').val(response.data.zipcode)
                $('#house_no').val(response.data.house_no)
                if (response.status == 406) {

                    $('#zipcode-error').text(response.data.message);
                    $('#zipcode-error').css("display", "block");
                } else {
                    location.reload()
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $.validator.addMethod(
        "alphaNumericalRegex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Only Alphabet and numeric values are allowed"
    );
});


function validateZipcode() {
    var zipcode = $('#zipcode').val();
    var house_no = $('#house_no').val();

    var url = baseURL + '/user/dashboard';

    $.ajax({
        url: baseURL + '/validateZipcode',
        type: 'POST',
        data: {
            zipcode, house_no
        },
        success: function (response) {

            if (response.status == 2) {
                $('#zipcode-error').text(response.message);
                $('#zipcode-error').css("display", "block");
            } else {
                window.location.href = url;
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function addTakeawayPhone() {

    var phone_no = $('#phone_no').val();

    $.ajax({
        url: baseURL + '/takeawayPhone',
        type: 'POST',
        data: {
            phone_no
        },
        success: function (response) {
            window.location.href = baseURL + '/user/dashboard';
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function deleteAddress(id) {
    $.ajax({
        url: baseURL + '/user/delete-address/' + id,
        type: 'GET',
        success: function (response) {
            console.log('success')
            console.log(response)
            $('#address-' + id).remove();
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
