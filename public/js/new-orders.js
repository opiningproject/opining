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


// screen wise show pagination code
document.addEventListener('DOMContentLoaded', function () {
    let screenWidth = window.innerWidth;
    let screenHeight = window.innerHeight; // Get screen height
    let perPage = 24;

    // Adjust perPage based on both screen width and height
    if (screenHeight < 769) {
        // perPage = 18;
    }
    else if (screenHeight > 1040) {
        // perPage = 36;
    }
    else if (screenHeight > 1000) {
        // perPage = 27;
    }
    else if (screenHeight > 900) {
        // perPage = 24;
    }
    // else if (screenHeight > 880) {
    //     perPage = 30;
    // }
    else if (screenHeight < 769) {
        // perPage = 24;
    }
    else if (screenHeight < 768) {
        // perPage = 21;
    }
    else {
        // perPage = 24;
    }

    // Get the currently stored per_page value from sessionStorage
    const storedPerPage = sessionStorage.getItem('per_page_value');
    // Check if per_page is already set in sessionStorage to avoid repeated reloads
    if (storedPerPage !== perPage.toString()) {
        // Send AJAX request to store perPage in session
        sessionStorage.setItem('per_page_value', perPage.toString());
        fetch('/set-per-page', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ per_page: perPage })
        }).then(response => {
            return response.json();
        }).then(data => {
            if (data.success) {
                // Set a flag in sessionStorage so that we don't reload again
                // sessionStorage.setItem('per_page_value', perPage.toString());
                // Reload the page to apply pagination with the new per_page value
                window.location.reload();
            }
        }).catch(error => {
            console.error('Error setting per_page:', error);
        });
    }
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
    $('.order-setting-popup').modal('show');
    $('#radio-button-error').remove();
    $('.error').remove();
})

$(function () {

    var urlParams = new URLSearchParams(window.location.search);
    var perPage = urlParams.get('per_page');

    var filters = [];
    var search = '';
    var searchOption = '';
    var perPageNew = perPage ? perPage : 24;
    // Keyup search handler
    $(document).on('change', '#order-tabs-dropdown', function () {
        search = $('#search-order-new').val();
        searchOption = $('#order-tabs-dropdown').val();
        searchFilterAjax(search, searchOption, filters, perPageNew)
    });

    $(document).on('keyup', '#search-order-new', function () {
        search = $(this).val();
        searchOption = $('#order-tabs-dropdown').val();
        searchFilterAjax(search, searchOption, filters, perPageNew)
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
                    per_page:perPageNew,
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

    if (filters.length > 0) {
        $('.count-filter').removeClass('d-none');
        $('.count-filter').text(filters.length);
    } else {
        $('.count-filter').addClass('d-none');
    }

    $('.order-type-label').on('click', function() {
        // Find the corresponding checkbox
        var checkbox = $(this).prev('.order-type-input'); // Assumes label is immediately after checkbox
        // Toggle the checked state of the checkbox
        checkbox.prop('checked', !checkbox.prop('checked'));

        // Add or remove the 'checked' class based on the checkbox state
        if (checkbox.prop('checked')) {
            checkbox.addClass('checked'); // Add 'checked' class if checked
        } else {
            checkbox.removeClass('checked'); // Remove 'checked' class if unchecked
        }
        // Log the currently checked checkboxes
        filters = [];
        $('.order-type-input:checked').each(function() {
            filters.push($(this).attr('id'));
        });
        if (filters.length > 0) {
            $('.count-filter').removeClass('d-none');
            $('.count-filter').text(filters.length);
        } else {
            $('.count-filter').addClass('d-none');
        }
        searchFilterAjax(search, searchOption, filters, perPageNew);
    });
    $('.dropdown-menu').on('click', function(e) {
        e.stopPropagation();
    });



    $(document).on('click', '.saveReset', function (e) {
        $.ajax({
            url: baseURL + '/save-reset',
            type: 'GET',
            success: function (response) {
                console.log("response", response)
                if (response.status == "success"){
                    $('.order-setting-popup').modal('hide')
                    $('.timezone-setting').prop('selectedIndex', 0);
                    $('input[name="date_type"]').removeAttr('checked');
                    // $('.date_type').prop('checked', false);
                    $('#order-setting-form').trigger("reset");
                    searchFilterAjax(search, searchOption, filters, perPageNew);
                }

            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    function searchFilterAjax(search, searchOption, filters, perPageNew) {
        $.ajax({
            url: baseURL + '/orders', // Ensure this matches your route
            type: 'GET',
            data: {
                search,
                searchOption,
                per_page:perPageNew,
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
// order-setting-form
    function parseDate(value) {
        var parts = value.split('-');
        return new Date(parts[2], parts[1] - 1, parts[0]);
    }
    $.validator.addMethod('validDate', function (value, element) {
        return this.optional(element) || /^(0?[1-9]|[12][0-9]|3[01])-(0?[1-9]|1[012])-[0-9]{4}$/.test(value);
    }, 'Please provide a date in the dd-mm-yyyy format');

    // Method to ensure start date is before end date
    $.validator.addMethod('dateBefore', function (value, element, params) {
        var endDate = $(params).val();
        if (!endDate) return true; // Skip comparison if endDate is empty
        var startDate = parseDate(value);
        var endDateObj = parseDate(endDate);

        return this.optional(element) || startDate <= endDateObj;
    }, 'Must be before the end date.');

    // Method to ensure end date is after start date
    $.validator.addMethod('dateAfter', function (value, element, params) {
        var startDate = $(params).val();
        if (!startDate) return true; // Skip comparison if startDate is empty
        var endDate = parseDate(value);
        var startDateObj = parseDate(startDate);

        return this.optional(element) || endDate >= startDateObj;
    }, 'Must be after the start date.');

    $(".order-setting-form").validate({
        rules: {
            timezone_setting: {
                required: true
            },
            start_date: {
                required: true,
                validDate: true,
                dateBefore: '#end-date'
            },
            end_date: {
                required: true,
                validDate: true,
                dateAfter: '#start-date'
            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
            $(element).addClass('border-red-500'); // Tailwind CSS class for red border
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
            $(element).removeClass('border-red-500');
            $(element).addClass('border-green-500'); // Tailwind CSS class for green border
        },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "start_date") {
                error.insertAfter(".start-date-input");
            } else if (element.attr("name") == "end_date") {
                error.insertAfter(".end-date-input");
            } else {
                error.insertAfter(element); // Default placement for other fields
            }
            return false;
        },
        submitHandler: function (form) { // <- pass 'form' argument in
            $(".submit").attr("disabled", true);
            saveOrderSetting(); // <- use 'form' argument here.
        }
    });

// Add deliverers
    function saveOrderSetting() {
        var delivererData = new FormData(document.getElementById('order-setting-form'));
        $('#radio-button-error').remove()
        if ($('#order-setting-date').prop('checked') == true) {
            if (!$('input[name="date_type"]:checked').length) {
                    var errorMessage = '<label style="color: red" id="radio-button-error" className="error radio-button-error" htmlFor="timezone_setting">Please select at least one date option before saving.</label>';
                    $('.date-range-section').append(errorMessage)
                return false;
                }
            saveOrderSettingAjaxCall(delivererData)
        } else {
            saveOrderSettingAjaxCall(delivererData)
        }
    }
    function saveOrderSettingAjaxCall(delivererData) {
        $.ajax({
            url: baseURL + '/save-order-setting',
            type: 'POST',
            processData: false,
            contentType: false,
            data: delivererData,
            success: function (response) {
                if (response.status == 'success') {
                    $('.order-setting-popup').modal('hide');
                    searchFilterAjax(search, searchOption, filters, perPageNew);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
            }
        })
    }
    console.log("perPageNew", perPageNew)
    $(document).on('change', '#per_page_dropdown', function () {
        var url = this.value;
        var urlObject = new URL(url); // Create a URL object from the string

        // Get the 'per_page' parameter value using URLSearchParams
        var urlPerPage = urlObject.searchParams.get('per_page');
        perPageNew = urlPerPage
        $('.numberOfPerPage').val(urlPerPage)
        $('#numberOfPerPageSearch').val(urlPerPage)
        // return false;
        searchFilterAjax(search, searchOption, filters, perPageNew)
        // window.open(url, '_parent');
        // searchFilterAjax(search, searchOption, filters);
    })
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

// function changeOrderStatusNew(order_id, order_status) {
//     var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", { transports: ['websocket', 'polling', 'flashsocket'] });
//
//     var orderId = order_id;
//     $.ajax({
//         url: baseURL + '/orders/change-status/' + orderId + '/' + order_status,
//         type: 'GET',
//         success: function (response) {
//             console.log("response", response)
//             if (response.status == 1) {
//                 $('.order-status-' + response.orderId).removeClass('outline-danger outline-warning outline-success btn-danger-outline outline-secondary');
//                 // $('.order-detail-popup').modal('hide')
//                 $('.order-status-' + response.orderId).addClass(response.color);
//                 $('.order-status-' + response.orderId).text(response.text);
//             }
//             if (response.orderStatus == "6") {
//                 $('#order-' + response.orderId).remove();
//                 var currentOrderCount = $('.order-count').text();
//                 $('.order-count').html(currentOrderCount - 1);
//                 $('.count-order').html(currentOrderCount - 1);
//                 window.location.reload()
//             }
//             socket.emit('orderTrackAdmin', response.orderId, response.updatedStatus, response.orderDate);
//         },
//         error: function (response) {
//             var errorMessage = JSON.parse(response.responseText).message
//             alert(errorMessage);
//         }
//     })
// }

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
/*function disabledOldOrderStatus() {
    const radios = document.querySelectorAll('.order-status-radio');

    // Define the allowed transitions between statuses
    const orderStatusMap = {
        'accepted-order': ['inKitchen-order'], // Only In Kitchen can be enabled from New Order
        'inKitchen-order': ['outForDelivery-order'], // Only Out For Delivery can be enabled from In Kitchen
        'outForDelivery-order': ['delivered-order'], // Only Delivered can be enabled from Out For Delivery
        'delivered-order': [] // No further status transitions from Delivered, so everything else is disabled
    };

    // Function to update the status of radio buttons
    function updateRadioStatus() {
        // Find how many radios are checked
        const checkedRadios = document.querySelectorAll('.order-status-radio:checked');

        // If no radio button is checked, disable all radio buttons
        if (checkedRadios.length === 0) {
            radios.forEach(radio => {
                radio.disabled = true;
            });
            return; // Exit early if no radio buttons are checked
        }

        // If a radio is checked, enable/disable the relevant radios
        radios.forEach(radio => {
            if (radio.checked) {
                const enabledRadios = orderStatusMap[radio.id]; // Get allowed statuses for the checked radio
                radios.forEach(r => {
                    // Enable only the radios in the allowed transition map, disable others
                    if (enabledRadios.includes(r.id)) {
                        r.disabled = false; // Enable the valid next step
                    } else if (r.id !== radio.id) {
                        r.disabled = true; // Disable all other radios except the current one
                    }
                });
            }
        });
    }

    // Initialize radio buttons on page load
    updateRadioStatus();

    // Add change event listener to radio buttons
    radios.forEach(radio => {
        radio.addEventListener('change', function () {
            // Enable all radios first, then re-apply the disabling logic
            radios.forEach(r => r.disabled = false); // Enable all radios first
            updateRadioStatus(); // Apply disabling logic based on the new selection
        });
    });
}

// Example usage
disabledOldOrderStatus();*/


// checked all checkboxs on click all checkbox.
/*$('#all').on('change', function () {
    // Check or uncheck all checkboxes based on 'all' checkbox state
    $('.order-filter .checkbox').not('#all').prop('checked', $(this).is(':checked'));
});

// If any individual checkbox is unchecked, also uncheck 'all'
$('.order-filter .checkbox').not('#all').on('change', function () {
    if (!$(this).is(':checked')) {
        $('#all').prop('checked', false);
    }
});

// Check if all checkboxes are selected, and if so, check 'all'
$('.order-filter .checkbox').not('#all').on('change', function () {
    if ($('.order-filter .checkbox').not('#all').length === $('.order-filter .checkbox:checked').not('#all').length) {
        $('#all').prop('checked', true);
    }
});*/

// Define the date range picker on the start date input
// var start = moment();
// var end = moment();

$('#start-date, #end-date').daterangepicker({
    singleDatePicker: true, // Allow selecting a date range
    showDropdowns: true,      // Show year and month dropdowns
    locale: {
        format: 'DD-MM-YYYY'
    },
    maxDate: moment(), // Set the maximum date to today
    autoclose: true,
});

// Handle apply event to update both start and end date inputs
$('#start-date').on('apply.daterangepicker', function (ev, picker) {
    // Update start date field
    $('#start-date').val(picker.startDate.format('DD-MM-YYYY'));
});
$('#end-date').on('apply.daterangepicker', function (ev, picker) {
    // Update end date field
    $('#end-date').val(picker.endDate.format('DD-MM-YYYY'));
});

// Optional: Clear the date inputs on cancel
$('#start-date').on('cancel.daterangepicker', function (ev, picker) {
    $('#start-date').val('');
    $('#end-date').val('');
});
$('#end-date').on('cancel.daterangepicker', function (ev, picker) {
    $('#start-date').val('');
    $('#end-date').val('');
});

// Set placeholders for both inputs
$('#start-date').attr('placeholder', 'Select Date Range');
$('#end-date').attr('placeholder', 'Select Date Range');

// show hide specific timezone specific day
document.addEventListener('DOMContentLoaded', function () {
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
            $('#radio-button-error').remove();
        } else if (dateRadio.checked) {
            timezoneSetting.classList.add('d-none');
            dateRange.classList.remove('d-none');
            $('.specific-timezone').removeClass('active')
            $('.specific-day').addClass('active')
            $('.timezone-setting').prop('selectedIndex', 0);
            $('.order_setting_type').val("2");
            $('#radio-button-error').remove();

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


$(document).on('click', '.custom_time_order_setting', function () {
    $('.custom-date-selector').removeClass('d-none')
    $('#radio-button-error').remove();
})

$(document).on('click', '.date_type', function () {
    $('#start-date').val('');
    $('#end-date').val('');
    $('#radio-button-error').remove();
    $('.custom-date-selector').addClass('d-none')
})

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
