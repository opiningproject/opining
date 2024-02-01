function orderDetail(id) 
{
    $.ajax({
            url: baseURL+'/user/orders/order-detail/' + id,
            type: 'GET',
            success: function (response) {
                //$('#address-'+id).remove();
                $('.ordersdetails').html(response);

                $(".orders-list div").removeClass("active");
                $('#order-'+id).addClass('active');
                $('#description').val('');

            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}

$(function () {
    $("#refund-form").validate({
        //debug:true,
        submitHandler: function (form) {
            sendRefundRequest();
        }
    });
})

function sendRefundRequest() 
{
    var order_id = $('#order_id').val();
    var description = $('#description').val();

     $.ajax({
            url: baseURL+'/user/orders/send-refund-req',
            type: 'POST',
            data: {
                order_id, description
            },
            success: function (response) {
                //$('#address-'+id).remove();
                $("#refund-req-btn").removeClass("active");
                $("#refund-status-lable").text("Refund request submitted");
                $("#refund-req-btn").css("pointer-events", "none");
                $('#refundModal').modal('hide')

            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
}



