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

function updateDishQty(operator,maxQty,dish_id) 
{
    var current_qty = parseInt($('input[name=qty-'+dish_id+']').val());

    if (operator == '-' && !isNaN(current_qty) && current_qty > 0) 
    {
        $('input[name=qty-'+dish_id+']').val(current_qty - 1);
    } 

    if (operator == '+' && !isNaN(current_qty)) 
    {
        if(current_qty >= maxQty)
        {
             return false;
        }

        $('input[name=qty-'+dish_id+']').val(current_qty + 1);
    }

    var current_qty = parseInt($('input[name=qty-'+dish_id+']').val());

    $.ajax({
            type: 'POST',
            url: baseURL+'/user/update-dish-qty',
            data: {
                dish_id,operator,current_qty
            },
            success: function (response) {
                if(response.status == 1 && parseInt(current_qty) == 0)
                {
                    $("#cart-"+dish_id).remove();
                    $("#dish-cart-lbl-"+dish_id).text('Add +');
                    $("#dish-cart-lbl-"+dish_id).prop('disabled', false);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}

function apply() 
{
    var coupon_code = $('#coupon_code').val();
    var order_amount = 30;

    if(coupon_code == '')
    {
        return false;
    }

    $.ajax({
            type: 'POST',
            url: baseURL+'/user/coupon/apply',
            data: {
                coupon_code,order_amount
            },
            success: function (response) {
                if(response.status == 1)
                {
                    $("#coupon_code_remove_btn").removeClass('d-none');
                    $("#coupon_code_apply_btn").addClass('d-none');
                    $("#coupon_code").prop('readonly', true);

                    $("#coupon-code-error").addClass('d-none');
                    $('#coupon-code-error').text('');
                }
                else
                {
                    $("#coupon-code-error").removeClass('d-none');
                    $('#coupon-code-error').text(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}

function remove() 
{
    $("#coupon_code_apply_btn").removeClass('d-none');
    $("#coupon_code_remove_btn").addClass('d-none');
    $('#coupon_code').val('');
    $("#coupon_code").prop('readonly', false);

}

