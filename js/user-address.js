$(function () 
{
    $("#sign-in-form").validate({
          //debug:true,
          submitHandler: function(form) {
            signIn();
          }
     });

   

});
