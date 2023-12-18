$(function () 
{
 
});


function addToCart(id) 
{
    $.ajax({
            url: baseURL+'/user/add-to-cart/' + id,
            type: 'GET',
            success: function (response) {
                //console.log('success')
                console.log(response)
                if(response.status == 1)
                {
                    $("#dish-cart-lbl-"+id).text('Added to cart');
                    $("#dish-cart-lbl-"+id).prop('disabled', true);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}


