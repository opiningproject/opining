// new order page js code start
$(document).on('click', '.orderDetails', function () {
    $('.order-detail-popup').modal('show')
})

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
        // if (search.length > 0) {
        /*$.ajax({
            url: baseURL + '/orders-new/search-order',
            type: 'POST',
            data: {
                search,
                searchOption,
            },
            datatype: 'json',
            success: function (response) {
                $('.orderList').html(response);
                $('.foodorder-box-details').html('');
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message;
                alert(errorMessage);
            }
        });*/
        console.log("filters", filters)
        /*$.ajax({
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
        });*/

        /*}*/ /*else {
            // If search is empty, load all orders
            $.ajax({
                url: baseURL + '/orders-new',
                type: 'GET',
                datatype: 'json',
                success: function (response) {
                    $('.orderList').html(response);
                    $('.foodorder-box-details').html('');
                },
                error: function (response) {
                    var errorMessage = JSON.parse(response.responseText).message;
                    alert(errorMessage);
                }
            });
        }*/
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
                    $('.foodorder-box-details').html('');
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
            // Send filters via AJAX
        } else {
            filters = []
        }
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


