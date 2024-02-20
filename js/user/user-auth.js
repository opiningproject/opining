$(function () {
    $("#sign-in-form").validate({
        submitHandler: function (form) {
            signIn();
        }
    });

    $("#sign-up-form").validate({
        //debug:true,
        rules: {
            password: {
                required: true,
                minlength: 8,
                regex: "^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[!@#$%&*])[a-zA-Z0-9!@#$%&*]+$",
            },
            c_password: {
                required: true,
                equalTo: "#password"
            },
        },
        submitHandler: function (form) {
            signUp();
        }
    });

    $("#forgot-pwd-form").validate({
        //debug:true,
        submitHandler: function (form) {
            forgotPassword();
        }
    });

    $(document).on("click", ".auth-link-check", function () {
        localStorage.setItem('target_url', $(this).attr('href'));

        if ($('#auth-check').val() == 0) {
            $('#signInModal').modal('show');
            event.preventDefault();
        }

    });

    $(document).on('click', '.login-signup-pwd-icon', function () {
        if ($('.login-pwd-icon').attr('type') == 'text') {
            $('.login-pwd-icon').attr('type', 'password')
        } else {
            $('.login-pwd-icon').attr('type', 'text')
        }
    })

    $('#resendPasswordModal').on('hidden.bs.modal', function () {
        var alertas = $('#forgot-pwd-form');
        alertas.validate().resetForm();
        alertas.trigger("reset");
        alertas.find('.error').removeClass('error');
        $('form#forgot-pwd-form').find('label[id=success-msg]').text('').css("display", "none");
        $('form#sign-up-form').find('label[id=email-error]').text('').css("display", "none");
    });

    $('#signInModal').on('hidden.bs.modal', function () {
        var alertas = $('#sign-in-form');
        alertas.validate().resetForm();
        alertas.trigger("reset");
        alertas.find('.error').removeClass('error');
    });

    $('#signUpModal').on('hidden.bs.modal', function () {
        var alertas = $('#sign-up-form');
        alertas.validate().resetForm();
        alertas.trigger("reset");
        alertas.find('.error').removeClass('error');
    });
});

function signIn() {
    $('#sign-in-btn').prop('disabled', true);

    var email = $('form#sign-in-form').find('input[name=email]').val();
    var password = $('form#sign-in-form').find('input[name=password]').val();

    $.ajax({
        url: baseURL + '/user/login',
        type: 'POST',
        data: {
            email, password
        },
        success: function (response) {

            //alert(localStorage.getItem('user_id'))

            if (response.status == 0) {
                $('form#sign-in-form').find('#' + response.field + '-error').css("display", "block");
                $('form#sign-in-form').find('#' + response.field + '-error').text(response.message);

                $('#sign-in-btn').prop('disabled', false);
            } else {
                window.location.reload();
                // window.location.href = localStorage.getItem('target_url');

            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function signUp() {
    $('#sign-up-btn').prop('disabled', true);

    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('form#sign-up-form').find('input[name=email]').val();
    var password = $('form#sign-up-form').find('input[name=password]').val();

    $.ajax({
        url: baseURL + '/user/signup',
        type: 'POST',
        data: {
            first_name, last_name, email, password
        },
        success: function (response) {
            if (response.status == 0) {
                $('form#sign-up-form').find('label[id=email-error]').text(response.message);
                $('form#sign-up-form').find('label[id=email-error]').css("display", "block");

                $('#sign-up-btn').removeAttr('disabled');
            } else {
                window.location.reload();
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function forgotPassword() {
    //var email = $('#forgot-pwd-email').val();
    var email = $('form#forgot-pwd-form').find('input[name=email]').val();

    $.ajax({
        url: baseURL +'/user/forgot-password',
        type: 'POST',
        data: {
            email
        },
        success: function (response) {
            if (response.status == 0) {
                $('form#forgot-pwd-form').find('label[id=email-error]').text(response.message);
                $('form#forgot-pwd-form').find('label[id=email-error]').css("display", "block");

                $('#forgot-pwd-btn').removeAttr('disabled');
            }else{
                $('form#forgot-pwd-form').find('label[id=success-msg]').text(response.message).css("display", "block");
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            $('#forgot-pwd-error-msg').text(errorMessage)

        }
    })
}
