$(function () 
{
 
});


function addToCart(id) 
{
    $.ajax({
            url: baseURL+'/user/add-to-cart/' + id,
            type: 'GET',
            success: function (response) {
              
                if(response.status == 2)
                {
                   $('#signInModal').modal('show');
                   return false;
                }

                $("#dish-cart-lbl-"+id).text('Added to cart');
                $("#dish-cart-lbl-"+id).prop('disabled', true);
                $('.cart-items').append(response);
                
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}

function updateDishQty(id,operator,maxQty,dishID) 
{
    var current_qty = parseInt($('input[name=qty-'+id+']').val());

    if (operator == '-' && !isNaN(current_qty) && current_qty > 0) 
    {
        $('input[name=qty-'+id+']').val(current_qty - 1);
    } 

    if (operator == '+' && !isNaN(current_qty)) 
    {
        if(current_qty >= maxQty)
        {
             return false;
        }

        $('input[name=qty-'+id+']').val(current_qty + 1);
    }

    var current_qty = parseInt($('input[name=qty-'+id+']').val());

    $.ajax({
            type: 'POST',
            url: baseURL+'/user/update-dish-qty',
            data: {
                id,operator,current_qty
            },
            success: function (response) {
                if(response.status == 1 && parseInt(current_qty) == 0)
                {
                    $("#cart-"+id).remove();
                    $("#dish-cart-lbl-"+dishID).text('Add +');
                    $("#dish-cart-lbl-"+dishID).prop('disabled', false);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}


