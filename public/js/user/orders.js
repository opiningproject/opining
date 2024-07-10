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
            $('.ordersdetails_sidebar').addClass('open')
            $('body').addClass('sidebar-open')

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

    $(document).on('click','.order-detail-close-btn',function (){
        $('.ordersdetails_sidebar').removeClass('open')
        $('body').removeClass('sidebar-open')
    })
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

var page = 2;
var isLoading = false;
var endOfData = false;
var lastPage = 9; // Adjust according to the last page number
var url = window.location.pathname;
var id = url.substring(url.lastIndexOf('/') + 1);
console.log("url",id)


$(".orders-list").scroll(function () {
    if (endOfData || isLoading) return;

    var scrollTop = $(this).scrollTop();
    var containerHeight = $(this).height();
    var contentHeight = $(this).get(0).scrollHeight;

    // Check if the scroll position reaches near the bottom of the container
    if (scrollTop + containerHeight >= contentHeight - 10) {
        console.log("in");
        isLoading = true; // Set loading state before making the request
        loadMoreData(page);
    }
});
//

function loadMoreData(currentPage) {
    $.ajax({
        url: '?page=' + currentPage,
        type: "get",
        beforeSend: function() {
            $('#loader').show();
        }
    })
        .done(function(data) {
            if (data.trim().length === 0 || currentPage >= lastPage) {
                $('#loader').hide();
                $('#end-of-data').show();
                endOfData = true;
                return;
            }

            $(".orders-list").append(data);
            if (id) {
                orderDetail(id)
            }
            $('#loader').hide();
            page = currentPage + 1; // Increment page number after successful data load
            isLoading = false; // Reset loading state
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            // alert('Server not responding...');
            isLoading = false; // Reset loading state even if the request fails
        });
}



