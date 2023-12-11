$(function () 
{
    var url = baseURL +'/user/dashboard';

    $("#delivery-add-form").validate({
          submitHandler: function(form) {
            validateZipcode();
            //window.location.href = url;
          }
     });

     $("#take-away-add-form").validate({
          submitHandler: function(form) {
            window.location.href = url;
          }
     });

    $("#address-form").validate({
          submitHandler: function(form) {
            //validateZipcode();
            window.location.href = url;
          }
     });
});


function validateZipcode() 
{
  var zipcode = $('#zipcode').val();
  var house_no = $('#house_no').val();

  var url = baseURL +'/user/dashboard';

  $.ajax({
        url: baseURL+'/validateZipcode',
        type: 'POST',
        data: {
            zipcode,house_no
        },
        success: function (response) {

            if(response.status == 2)
            {
                $('#zipcode-error').text(response.message);
                $('#zipcode-error').css("display", "block"); 
            }
            else
            {
                window.location.href = url;
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function deleteAddress(id) 
{
    $.ajax({
            url: baseURL+'/user/delete-address/' + id,
            type: 'GET',
            success: function (response) {
                console.log('success')
                console.log(response)
                $('#address-'+id).remove();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}


