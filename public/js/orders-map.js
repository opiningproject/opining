// status-option-deliverers active inactive
$(document).ready(function () {
    // On click of a radio button label
    $('.status-option-deliverers input[type="radio"]').change(function () {
        $('.status-option-deliverers').removeClass('active');
        $(this).closest('.status-option-deliverers').addClass('active');
    });
});

function cancelOrder(id) {
    $('#cancelOrderModal').modal('show');
}

$(document).on('click', '#cancel-order-btn', function () {

    //$('#zipcode-delete-btn').prop('disabled',true);

    var id = $('.order_id').val();
    var status = $('.cancel_order').val();

    $.ajax({
        url: baseURL + '/cancel-order/' + id + '/' + status,
        type: 'GET',
        success: function (response) {
            /*  $('#deleteZipcodeModal').modal('toggle');
              $('.zipcode-row-' + id).remove();
              toastr.success(response.message)*/
            if (response.status == 1) {
                $('.order-status-' + response.orderId).removeClass('outline-danger outline-warning outline-success btn-danger-outline outline-secondary');
                $('.order-detail-popup').modal('hide')
                $('#order-' + response.orderId).remove();
                $('.order-status-' + response.orderId).addClass(response.color);
                $('.order-status-' + response.orderId).text(response.text);
                var currentOrderCount = $('.order-count').text();
                $('.order-count').html(currentOrderCount - 1);
                $('.count-order').html(currentOrderCount - 1);
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
})

// order-status-option active inactive
$(document).ready(function () {
    $(document).on('change', '.order-status-option input[type="radio"]', function () {
        $('.order-status-option').removeClass('active');
        $(this).closest('.order-status-option').addClass('active');
    });
});


$(function () {
    var filters = [];
    var search = '';
    var searchOption = '';
    // Keyup search handler
    $(document).on('change', '#order-tabs-dropdown', function () {
        search = $('#search-order-new').val();
        searchOption = $('#order-tabs-dropdown').val();
        searchFilterAjax(search, searchOption, filters)
    });

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

    $('.order-radio-group input[type="radio"]').on('click', function() {
        // Get the selected radio value
        filters = [];
        var selectedValue = $(this).val();
        filters.push($(this).val());
        searchFilterAjax(search, searchOption, filters)
    });

    function searchFilterAjax(search, searchOption, filters) {
        $.ajax({
            url: baseURL + '/orders-map', // Ensure this matches your route
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
    //order setting js code start
});

function orderDetailNew(id) {
    $.ajax({
        url: baseURL + '/orders/order-detail/' + id,
        type: 'GET',
        success: function (response) {
            if (response.status == 1) {
                $('.order-notification-popup').modal('hide')
                $('.order-detail-popup').html(response.data);
                $('.order-detail-popup').modal('show')
                disabledOldOrderStatus()
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function changeOrderStatusNew(order_id, order_status) {
    var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", { transports: ['websocket', 'polling', 'flashsocket'] });

    var orderId = order_id;
    $.ajax({
        url: baseURL + '/orders/change-status/' + orderId + '/' + order_status,
        type: 'GET',
        success: function (response) {
            console.log("response", response)
            if (response.status == 1) {
                $('.order-status-' + response.orderId).removeClass('outline-danger outline-warning outline-success btn-danger-outline outline-secondary');
                // $('.order-detail-popup').modal('hide')
                $('.order-status-' + response.orderId).addClass(response.color);
                $('.order-status-' + response.orderId).text(response.text);
            }
            if (response.orderStatus == "6") {
                $('#order-' + response.orderId).remove();
                var currentOrderCount = $('.order-count').text();
                $('.order-count').html(currentOrderCount - 1);
                $('.count-order').html(currentOrderCount - 1);
                window.location.reload()
            }
            socket.emit('orderTrackAdmin', response.orderId, response.updatedStatus, response.orderDate);
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function assignDeliverer(order_id, deliverer_id) {
    var orderId = order_id;
    var delivererId = deliverer_id;
    $.ajax({
        url: baseURL + '/add-deliverer/' + orderId + '/' + deliverer_id,
        type: 'GET',
        success: function (response) {
            console.log("response", response)
            if (response.status == 1) {
                $('.order-detail-popup').modal('hide')
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function disabledOldOrderStatus() {
    const radios = document.querySelectorAll('.order-status-radio');

    // Function to update the status of radio buttons
    function updateRadioStatus() {
        // Find the checked radio button
        const checkedRadio = document.querySelector('.order-status-radio:checked');

        if (checkedRadio) {
            let disablePrevious = true; // Flag to disable previous radios
            radios.forEach(radio => {
                if (radio === checkedRadio) {
                    disablePrevious = false; // Stop disabling after the checked radio
                }
                if (disablePrevious) {
                    radio.disabled = true; // Disable previous radios
                } else {
                    radio.disabled = false; // Keep the current and future radios enabled
                }
            });
        } else {
            // If no radio is checked, enable all radios
            radios.forEach(radio => {
                radio.disabled = false;
            });
        }
    }

    // Initialize radio buttons on page load
    updateRadioStatus();

    // Add change event listener to radio buttons
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            updateRadioStatus(); // Apply the disabling logic based on the new selection
        });
    });
}

// Call the function to initialize it
disabledOldOrderStatus();


$(document).on('click', '.update-delivery-time', function () {
    var getMinute = $(this).text(); // +5 or -5
    var orderId = $('.order_id').val();
    var curruntTime = $('.expected_time_order').val();

    // Convert the current time (HH:mm) to minutes for easier comparison
    var timeParts = curruntTime.split(':');
    var hours = parseInt(timeParts[0]);
    var minutes = parseInt(timeParts[1]);
    var totalMinutes = hours * 60 + minutes;

    // Update the time based on the button clicked
    if (getMinute === '+5') {
        totalMinutes += 5;
    } else if (getMinute === '-5') {
        totalMinutes -= 5;
    }

    // Convert total minutes back to HH:mm format
    var newHours = Math.floor(totalMinutes / 60) % 24;
    var newMinutes = totalMinutes % 60;
    var newTime = ('0' + newHours).slice(-2) + ':' + ('0' + newMinutes).slice(-2);

    // Disable +5 if time reaches 24:00 and -5 if time reaches 00:00
    if (newHours === 0 && newMinutes === 0) {
        $('.update-delivery-time:contains("-5")').prop('disabled', true);
    } else {
        $('.update-delivery-time:contains("-5")').prop('disabled', false);
    }

    if (newHours === 23 && newMinutes === 55) {
        $('.update-delivery-time:contains("+5")').prop('disabled', true);
    } else {
        $('.update-delivery-time:contains("+5")').prop('disabled', false);
    }

    // Send updated data to the server via AJAX
    $.ajax({
        url: baseURL + '/update-delivery-time',
        type: 'POST',
        data: {
            orderId: orderId,
            getMinute: getMinute,
            curruntTime: curruntTime
        },
        success: function (response) {
            if (response.status == 'success') {
                $('.expected_time_order').val(response.expected_time_order);
                $('.expectedDeliveryTime-' + orderId).text(response.expected_time_order);
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message;
            toastr.error(errorMessage);
        }
    });
});

$(document).ready(function () {
    var currentUrl = window.location.href;
    var lastElement = currentUrl.split('/').pop();
    // Check if lastElement is a number, and then call a function
    if (!isNaN(lastElement)) {
        orderDetailNew(lastElement)
    } else {
        console.log("The last element is not a number.");
    }
});


$(document).on('focus', '.expected_time_order', function () {
    // Store the original time value when the input gains focus
    $(this).data('original-time', this.value);
});

$(document).on('change', '.expected_time_order', function () {
    let newTime = this.value;
    let originalTime = $(this).data('original-time');
    let orderId = $('.order_id').val();
    console.log("Original Time: ", originalTime);
    console.log("New Time: ", newTime);

    if (/^\d{2}:\d{2}$/.test(newTime)) {
        if (newTime >= originalTime) {
            $('.expected_time_order_error').addClass('d-none')
            updateDeliveryTime(newTime, orderId,);
        } else {
            $('.expected_time_order').val(originalTime)
            $('.expected_time_order_error').removeClass('d-none')
        }
    } else {
        alert('Please enter a valid time in HH:MM format.');
    }
});

function updateDeliveryTime(newTime,orderId) {
    // Perform an AJAX call
    $.ajax({
        url: baseURL + '/update-wished-time', // Your Laravel route to handle the request
        method: 'POST',
        data: {
            orderId: orderId,
            expected_time: newTime
        },
        success: function (response) {
            if (response.status == 'success') {
                $('.expected_time_order').text(response.expected_time_order);
                $('.expectedDeliveryTime-' + orderId).text(response.expected_time_order);
            } else {
                alert('Failed to update the expected delivery time.');
            }
        },
        error: function () {
            alert('Error updating the expected delivery time.');
        }
    });
}
