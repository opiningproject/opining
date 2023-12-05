$(function () 
{
    $("#sign-in-form").validate({
          //debug:true,
          submitHandler: function(form) {
            signIn();
          }
     });

    $("#sign-up-form").validate({
          //debug:true,
          submitHandler: function(form) {
            signUp();
          }
     });

    $("#forgot-pwd-form").validate({
          //debug:true,
          submitHandler: function(form) {
            forgotPassword();
          }
     });


});

function signIn() 
{
    $('#sign-in-btn').prop('disabled',true);

    var email = $('#email').val();
    var password = $('#password').val();
   
    $.ajax({
        url: 'user/login',
        type: 'POST',
        data: {
            email,password
        },
        success: function (response) {
            console.log('success')
            console.log(response)
            //window.location.reload();
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function signUp() 
{
    $('#sign-up-btn').prop('disabled',true);

    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var email = $('form#sign-up-form').find('input[name=email]').val();
    var password = $('form#sign-up-form').find('input[name=password]').val();
   
    $.ajax({
        url: 'user/signup',
        type: 'POST',
        data: {
            first_name,last_name,email,password
        },
        success: function (response) {
            console.log('success')
            console.log(response)
            //window.location.reload();
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function forgotPassword() 
{
    //var email = $('#forgot-pwd-email').val();
    var email = $('form#forgot-pwd-form').find('input[name=email]').val();

    $.ajax({
        url: 'user/forgot-password',
        type: 'POST',
        data: {
            email
        },
        success: function (response) {
            console.log('success')
            console.log(response)
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            $('#forgot-pwd-error-msg').text(errorMessage)

        }
    })
}

