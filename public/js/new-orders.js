// status-option-deliverers active inactive
$(document).ready(function () {
    // On click of a radio button label
    $('.status-option-deliverers input[type="radio"]').change(function () {
        $('.status-option-deliverers').removeClass('active');
        $(this).closest('.status-option-deliverers').addClass('active');
    });
});

// order-status-option active inactive
$(document).ready(function () {
    $(document).on('change', '.order-status-option input[type="radio"]', function () {
        $('.order-status-option').removeClass('active');
        $(this).closest('.order-status-option').addClass('active');
    });
});

//show order setting popup
$(document).on('click', '.order-setting', function () {
    $('.order-setting-popup').modal('show')
})

// on click order-notification-popup hide and show order details popup
$(document).on('click', '.order_details_button', function () {
    $('.order-notification-popup').modal('hide')
    $('.order-detail-popup').modal('show')

})


$(function () {
    var filters = [];
    var search = '';
    var searchOption = '';
    // Keyup search handler
    $(document).on('keyup', '#search-order-new', function () {
        search = $(this).val();
        searchOption = $('#order-tabs-dropdown').val();
        searchFilterAjax(search, searchOption, filters)
    });

    // Bind pagination link click event only once
    paginationLink();

    function paginationLink() {
        // Pagination link click handler
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var url = $(this).attr('href'); // Get the pagination link URL
            var search = $('#search-order-new').val(); // Get the current search term
            var searchOption = $('#order-tabs-dropdown').val(); // Get the current search option

            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    search: search,
                    searchOption: searchOption,
                    filters: filters,
                },
                datatype: 'json',
                success: function (response) {
                    $('.orderList').html(response);
                },
                error: function (response) {
                    var errorMessage = JSON.parse(response.responseText).message;
                    alert(errorMessage);
                }
            });
        });
    }

    $('.order-filter input[type="checkbox"]').on('change', function () {
        // Get selected checkboxes
        if ($('.order-filter input[type="checkbox"]:checked').length > 0) {
            $('.order-filter input[type="checkbox"]:checked').each(function () {
                filters.push($(this).attr('id')); // Get the ID of the checkbox (e.g., 'online', 'manual')
            });
        } else {
            filters = []
        }
        // Send filters via AJAX
        searchFilterAjax(search, searchOption, filters)
    });


    function searchFilterAjax(search, searchOption, filters) {
        $.ajax({
            url: baseURL + '/orders-new', // Ensure this matches your route
            type: 'GET',
            data: {
                search,
                searchOption,
                filters: filters.length > 0 ? filters : [],
            },
            success: function (response) {
                $('.orderList').html(response); // Replace order list with filtered data
            },
            error: function (error) {
                console.log('Error:', error);
            }
        });
    }
});

function orderDetailNew(id) {
    $.ajax({
        url: baseURL + '/orders/order-detail-new/' + id,
        type: 'GET',
        success: function (response) {
            if (response.status == 1) {
                $('.order-detail-popup').html(response.data);
                $('.order-detail-popup').modal('show')
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function changeOrderStatusNew(order_id,order_status)
{
    console.log("123123",order_id,order_status)
    var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", {transports: ['websocket', 'polling', 'flashsocket']});

    var orderId = order_id;
    $.ajax({
        url: baseURL+'/orders/change-status-new/'+ orderId,
        type: 'GET',
        success: function (response) {
            console.log("response", response)
            if (response.status == 1) {
                $('.order-detail-popup').modal('hide')
            }
            // Add gray-clock icon without refresh
            // if(response.clok_gray_svg) {
            //     $('.order-status-' + id).empty();
            //     $('.order-status-' + id).html(response.clok_gray_svg);
            // }
            if (response.orderStatus == "6") {
                var currentOrderCount = $('.order-count').text();
                console.log(currentOrderCount)
                $('.order-count').html(currentOrderCount - 1);
            }
            // $('.foodorder-box-details').html(response.data);
            //
            // $(".foodorder-box-list div").removeClass("active");
            // $('.order-' + id).addClass('active');
            // window.history.pushState('','', baseURL + '/orders/'+id+'#order-'+id);
            // $('#changeStatusModal').modal('hide');
            socket.emit('orderTrackAdmin', response.orderId, response.updatedStatus, response.orderDate);
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}


