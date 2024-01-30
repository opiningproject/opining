$("#user-profile-form").validate({
      //debug:true,
      submitHandler: function(form) {
        return true;
      }
});

function readMore(id) 
{
    $('#close-'+id).show()
    $('#read-more-'+id).hide()  

    $("#order-ingredient-"+id).removeClass('line-clamp-2');  
}

function hideReadMore(id) 
{
    $('#close-'+id).hide()
    $('#read-more-'+id).show()  

    $("#order-ingredient-"+id).addClass('line-clamp-2');  
}

