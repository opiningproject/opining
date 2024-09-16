$(function () {
    $(document).on('keyup', '#archive-search-order', function () {
        var search = $(this).val();


        $.ajax({
            url: baseURL + '/archive/searchOrder',
            type: 'POST',
            data: {
                search
            },
            datatype: 'json',
            success: function (response) {
                $('#archive-order-list-data-div1').html(response)
                $('.foodorder-box-details ').html('')
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })
})


function orderDetailArchive(id) {
    $.ajax({
        url: baseURL + '/archive/order-detail/' + id,
        type: 'GET',
        success: function (response) {
            $('.foodorder-box-details').html(response);

            $(".foodorder-box-list div").removeClass("active");
            $('.foodorder-box-list .time img').attr('src', baseURL + '/images/clock-gray.svg');
            $('.order-' + id).addClass('active');
            $('.foodorder-box-list .active .time img').attr('src', baseURL + '/images/clock-black.svg');
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}


var start = moment().subtract(10, 'days');
var end = moment();

var dateRange =''
$('#archive_expiry_date').daterangepicker({
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

$('#archive_expiry_date').val('')
$('#archive_expiry_date').attr('placeholder','Select Date Range')

$('#archive_expiry_date').on('apply.daterangepicker', function(ev, picker) {

    dateRange = $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));

    var start_date = picker.startDate.format('DD-MM-YYYY');
    var end_date = picker.endDate.format('DD-MM-YYYY');

    value = "start_date="+ start_date + "&end_date=" + end_date;

    window.location.href = `${baseURL}/archive?${value}`;
});

$('#archive_expiry_date').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});

$('#archive-clear').on("click",function()
{
    window.location.href = `${baseURL}/archive`;
});

 // Get start and end dates from URL parameters
 var startDates = getUrlParameterArchive('start_date');
 var endDates = getUrlParameterArchive('end_date');

if (startDates && endDates) {
    $('#archive_expiry_date').data('daterangepicker').setStartDate(moment(startDates, 'DD-MM-YYYY'));
    $('#archive_expiry_date').data('daterangepicker').setEndDate(moment(endDates, 'DD-MM-YYYY'));
    $('#archive_expiry_date').val(startDates + ' - ' + endDates);
}


function getUrlParameterArchive(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}


var pages = 2;
var isLoadings = false;
var endOfDatas = false;
var lastPages = $('.archive_last_page').html(); // Adjust according to the last page number

$(".archive-all-orders").scroll(function () {
    var url = `${baseURL}/archive`;
    if (endOfDatas || isLoadings) return;

    var scrollTop = $(this).scrollTop();
    var containerHeight = $(this).height();
    var contentHeight = $(this).get(0).scrollHeight;

    // Check if the scroll position reaches near the bottom of the container
    if (scrollTop + containerHeight >= contentHeight - 10) {
        isLoadings = true; // Set loading state before making the request
        loadMoreDataArchiveOrder(pages, url);
    }
});
//

function loadMoreDataArchiveOrder(currentPage, url) {
    $.ajax({
        url: url +'?page=' + currentPage,
        type: "get",
        beforeSend: function() {
            $('#loader').show();
        }
    })
        .done(function(data) {
            if (data.trim().length === 0 || currentPage >= lastPages) {
                $('#loader').hide();
                $('#end-of-data').show();
                endOfDatas = true;
                return;
            }
            $(".archive-all-orders").append(data);
            $('#loader').hide();
            pages = currentPage + 1; // Increment page number after successful data load
            isLoadings = false; // Reset loading state
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            // alert('Server not responding...');
            isLoadings = false; // Reset loading state even if the request fails
        });
}
