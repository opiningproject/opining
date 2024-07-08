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
        url: baseURL+'/orders/change-status/'+ id,
        type: 'GET',
        success: function (response) {

            // Add gray-clock icon without refresh
            if(response.clok_gray_svg) {
                $('.order-status-' + id).empty();
                $('.order-status-' + id).html(response.clok_gray_svg);
            }
            if (response.orderStatus == "6") {
                $('#order-list-data-div .order-' + id).remove();

                // get realtime open order count
                var totalAmountCount = $('.order-count').text();
                totalAmountCount = totalAmountCount.replace('€', '').trim();
                var currentOrderCount = $('.foodorder-box-list .active .total_amount').html()
                var amountWithoutEuro = currentOrderCount.replace('€', '').trim();
                currentOrderCount = parseFloat(amountWithoutEuro);
                $('.order-count').html('€' + parseFloat(totalAmountCount - currentOrderCount).toFixed(2));
            }
            $('.foodorder-box-details').html(response.data);

            $(".foodorder-box-list div").removeClass("active");
            $('.order-' + id).addClass('active');
            window.history.pushState('','', baseURL + '/orders/'+id+'#order-'+id);
            $('#changeStatusModal').modal('hide');
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
})

