$(function () 
{
    $("#rest-profile-form").validate({
          //debug:true,
          submitHandler: function(form) {
            return true;
          }
     });

    $("#change-password-form").validate({
          //debug:true,
          submitHandler: function(form) {
            changePassword();
          }
     });
});

function changePassword() 
{
    //$('#change-password-btn').prop('disabled',true);

    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var c_password = $('#c_password').val();

    if(c_password != new_password)
    {
        $("#c_password-error").removeClass('d-none');
        return false;
    }
   
    $.ajax({
        url: baseURL+'/settings/change-password',
        type: 'POST',
        data: {
            old_password,new_password
        },
        success: function (response) {
            //$('#change-password-btn').prop('enabled',true);

            if(response == 2)
            {
                $("#old_password-error").removeClass('d-none');
            }
            else
            {
                $("#changePasswordModal").modal('hide');
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

$('#changePasswordModal').on('hidden.bs.modal', function () 
{
  $('#change-password-form').trigger('reset');
  $("#changePasswordModal").find('.error').removeClass("error");

  $("#old_password-error").addClass('d-none');
  $("#new_password-error").addClass('d-none');
  $("#c_password-error").addClass('d-none');
});