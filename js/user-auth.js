$(function () 
{
    $("#sign-in-form").validate({
          //debug:true,
          submitHandler: function(form) {
            signIn();
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
