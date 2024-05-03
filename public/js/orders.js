function orderDetail(id) 
{
    $.ajax({
            url: baseURL+'/orders/order-detail/' + id,
            type: 'GET',
            success: function (response) {
                $('.foodorder-box-details').html(response);

                $(".foodorder-box-list div").removeClass("active");
                $('#order-'+id).addClass('active');
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}



