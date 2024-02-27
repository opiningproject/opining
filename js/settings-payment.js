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

