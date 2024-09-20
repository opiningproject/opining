$(function () {
    $("#rest-profile-form").validate({
        rules:{
            phone_no:{
                maxlength: 14,
                minlength: 6
            }
        },
        submitHandler: function (form) {
            toastr.success($('#settings_update_success').text())
            return true;
        }
    });

    $("#change-password-form").validate({
        rules:{
            new_password: {
                required: true,
                minlength: 8,
                regex: "^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%&*])[a-zA-Z0-9!@#$%&*]+$",
            },
            old_password: {
                required: true,
            },
            c_password: {
                required: true,
                equalTo: "#new_password"
            }
        },
        submitHandler: function (form) {
            changePassword();
        }
    });

    $(document).on('change', '#restaurant-logo-input-file', function () {
        addLogoReadURL(this);
    });

    $(document).on('change', '#restaurant-footer-logo-input-file', function () {
        addFooterLogoReadURL(this);
    });

    $(document).on('change', '#permit-doc-input-file', function () {
        editPermitReadURL(this);
    });

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        $('#password_error').text(),
    );

});

function changePassword()
{
    //$('#change-password-btn').prop('disabled',true);
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var c_password = $('#c_password').val();

    if (c_password != new_password) {
        $("#c_password-error").removeClass('d-none');
        return false;
    }

    $.ajax({
        url: baseURL + '/settings/change-password',
        type: 'POST',
        data: {
            old_password, new_password
        },
        success: function (response)
        {
            console.log(response)

            if (response == '2')
            {
                $("#old_password-error").removeClass('d-none');
            }
            else
            {
                $("#changePasswordModal").modal('hide');
                toastr.success(response.message)
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

$('#changePasswordModal').on('hidden.bs.modal', function () {
    var alertas = $('#change-password-form');
    alertas.trigger("reset");
    alertas.validate().resetForm();

    $("#old_password-error").addClass('d-none');
    $("#new_password-error").addClass('d-none');
    $("#c_password-error").addClass('d-none');
});

function addLogoReadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function editPermitReadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#permit-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function addFooterLogoReadURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#footer-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function checkScreenSize() {
    if ($(window).width() <= 767) {
        $('body').addClass('title-becomes');
    } else {
        $('body').removeClass('title-becomes');
    }
}

function checkScreenSize1() {
    if ($(window).width() <= 767) {
        $('body').removeClass('title-becomes');
    } else {
        $('body').addClass('title-becomes');
    }
}

// Add event listener for window resize
$(window).on('resize', checkScreenSize);

$(document).on('click','#menu-sidebar', function () {
    checkScreenSize();
});
$(document).on('click','#menu-sidebar-close', function () {
    checkScreenSize1();
});
