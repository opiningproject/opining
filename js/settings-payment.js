function changeRefundStatus(order_id,status) 
{
    //alert(order_id);

    $.ajax({
        url: baseURL + '/settings/change-refund-status',
        type: 'POST',
        data: {
            order_id, status
        },
        success: function (response) {

            if(response.status == 1)
            {
                $('.refund_status_box_'+order_id).addClass('d-none');
                $('.refund_status_text_'+order_id).text(response.data.status_text);
            }
            else
            {
                alert(response.message)
            }
           
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function changeOrderStatus(order_id,order_status) 
{
    $('#id').val(order_id);
    $('#changeStatusModal').modal('show');
    $('#order_status_name').text("'"+order_status+"'");
}


$(document).on('click', '#change-order-status-btn', function () 
{
    var id = $('#id').val();

    $.ajax({
        url: 'orders/change-status/'+ id,
        type: 'GET',
        success: function (response) {

            //alert("fgf")
            location.reload()
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
})

