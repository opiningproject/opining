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
            url: baseURL + '/orders', // Ensure this matches your route
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

function changeOrderStatusNew(order_id,order_status) {
    var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", {transports: ['websocket', 'polling', 'flashsocket']});

    var orderId = order_id;
    $.ajax({
        url: baseURL+'/orders/change-status/'+ orderId,
        type: 'GET',
        success: function (response) {
            console.log("response", response)
            if (response.status == 1) {
                $('.order-status-' + response.orderId).removeClass('outline-danger outline-warning outline-success btn-danger-outline outline-secondary');
                $('.order-detail-popup').modal('hide')
                $('.order-status-' + response.orderId).addClass(response.color);
                $('.order-status-' + response.orderId).text(response.text);
            }
            if (response.orderStatus == "6") {
                var currentOrderCount = $('.order-count').text();
                $('.order-count').html(currentOrderCount - 1);
                $('.count-order').html(currentOrderCount - 1);
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
        url: baseURL+'/add-deliverer/'+ orderId + '/' + deliverer_id,
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
    const orderStatusMap = {
        'accepted-order': ['inKitchen-order', 'outForDelivery-order', 'delivered-order'], // Assuming 'accepted-order' is New Order
        'inKitchen-order': ['accepted-order', 'outForDelivery-order', 'delivered-order'], // Assuming 'inKitchen-order' is In Kitchen
        'outForDelivery-order': ['accepted-order', 'inKitchen-order', 'delivered-order'], // Assuming 'outForDelivery-order' is Ready For Pickup or Out For Delivery
        'delivered-order': ['accepted-order', 'inKitchen-order', 'outForDelivery-order']  // Assuming 'delivered-order' is Delivered
    };

    function updateRadioStatus() {
        radios.forEach(radio => {
            if (radio.checked) {
                orderStatusMap[radio.id].forEach(id => {
                    document.getElementById(id).disabled = true;
                });
            } else {
                radio.disabled = false;
            }
        });
    }

    // Initialize radio buttons on page load
    updateRadioStatus();

    // Add change event listener to radio buttons
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Log the change for debugging
            console.log(this.id + ' is checked');

            // Update radio statuses based on the current selection
            radios.forEach(r => r.disabled = false); // Enable all radios first
            updateRadioStatus();
        });
    });
}


//order setting js code start
// order-setting-form
$(".order-setting-form").validate({
    rules: {
        timezone_setting:{
            required: true
        },
        expiry_date:{
            required: true
        }
    },
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
        $(element).addClass('border-red-500'); // Tailwind CSS class for red border
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
        $(element).removeClass('border-red-500');
        $(element).addClass('border-green-500'); // Tailwind CSS class for green border
    },
    errorPlacement: function(error, element) {
      error.insertAfter(element); // Default placement for other fields
        return false;
    },
    submitHandler: function(form) { // <- pass 'form' argument in
        $(".submit").attr("disabled", true);
        saveOrderSetting(); // <- use 'form' argument here.
    }
});

// Add deliverers
function saveOrderSetting() {
    var delivererData = new FormData(document.getElementById('order-setting-form'));
    $.ajax({
        url: baseURL + '/save-order-setting',
        type: 'POST',
        processData: false,
        contentType: false,
        data: delivererData,
        success: function (response) {
            if (response.status == 'success') {
                $('.order-setting-popup').modal('hide');
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
}
// Show date picker code
var start = moment().subtract(10, 'days');
var end = moment();

var dateRange = ''
console.log("dddd", $('.order-setting-custom-time').val())
var existingDate = $('.order-setting-custom-time').val() ?? null;
    $('#order-setting-custom-time').daterangepicker({
        startDate: start,
        endDate: end,
        maxDate: moment(),
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    });
if (existingDate) {
    var dates = existingDate.split(' - ');
    var start_date = dates[0];
    var end_date = dates[1];
    $('#order-setting-custom-time').data('daterangepicker').setStartDate(moment(start_date, 'DD-MM-YYYY'));
    $('#order-setting-custom-time').data('daterangepicker').setEndDate(moment(end_date, 'DD-MM-YYYY'));
    $('#order-setting-custom-time').val(start_date + ' - ' + end_date);
} else {
    $('#order-setting-custom-time').val('')
}
$('#order-setting-custom-time').attr('placeholder', 'Select Date Range')

$('#order-setting-custom-time').on('apply.daterangepicker', function (ev, picker) {

    dateRange = $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));

    var start_date = picker.startDate.format('DD-MM-YYYY');
    var end_date = picker.endDate.format('DD-MM-YYYY');

    value = "start_date=" + start_date + "&end_date=" + end_date;

    // window.location.href = `${baseURL}/orders?${value}`;
});

$('#order-setting-custom-time').on('cancel.daterangepicker', function (ev, picker) {
    $(this).val('');
});

// show hide specific timezone specific day
document.addEventListener('DOMContentLoaded', function() {
    const timezoneRadio = document.getElementById('order-setting-timezone');
    const dateRadio = document.getElementById('order-setting-date');
    const timezoneSetting = document.getElementById('timezone-setting');
    const dateRange = document.getElementById('date-range');

    function toggleSettings() {
        //timezone
        // 1 is use for timezon and 2 is use for specific-day
        if (timezoneRadio.checked) {
            timezoneSetting.classList.remove('d-none');
            dateRange.classList.add('d-none');
            $('.specific-timezone').addClass('active')
            $('.specific-day').removeClass('active')
            $('#order-setting-custom-time').val('');
            $('.order_setting_type').val("1");
        } else if (dateRadio.checked) {
            timezoneSetting.classList.add('d-none');
            dateRange.classList.remove('d-none');
            $('.specific-timezone').removeClass('active')
            $('.specific-day').addClass('active')
            $('.timezone-setting').prop('selectedIndex',0);
            $('.order_setting_type').val("2");

            $(this).closest('.status-option').addClass('active')
        }
    }

    // Add event listeners
    timezoneRadio.addEventListener('change', toggleSettings);
    dateRadio.addEventListener('change', toggleSettings);

    // Initial check in case of pre-selected values when modal loads
    toggleSettings();
});

$(document).on('click', '.update-delivery-time', function () {
    var getMinute = $(this).text();
    var orderId = $('.order_id').val();
    $.ajax({
        url: baseURL + '/update-delivery-time',
        type: 'POST',
        data: {
            orderId: orderId,
            getMinute: getMinute
        },
        success: function (response) {
            if (response.status == 'success') {
                $('.expected_time_order').text(response.expected_time_order);
                $('.expectedDeliveryTime-' + orderId).text(response.expected_time_order);
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
        }
    })
})

/*$(document).on('click', '.order_details_button', function () {
    var urlLastElement = document.location.pathname
    if (urlLastElement == '/orders') {
        let id = $(this).attr("data-id");
        $('.order-' + id).addClass('active');
        $('.order-notification-popup').modal('hide')
    } else {
        $('.order-notification-popup').modal('hide')
    }

})*/

$(document).ready(function () {
    var currentUrl = window.location.href;
// Split the URL by '/' and get the last element
    var lastElement = currentUrl.split('/').pop();
// Check if lastElement is a number, and then call a function
    if (!isNaN(lastElement)) {
        orderDetailNew(lastElement)
        // console.log("lastElement", lastElement); // Call your function here
    } else {
        console.log("The last element is not a number.");
    }
});
