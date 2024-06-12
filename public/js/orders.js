$(function () {
    $(document).on('keyup', '#search-order', function () {
        var search = $(this).val();
        var activeId = $('.foodorder-box-list-item.active').attr('data-id')

        console.log(activeId)

        $.ajax({
            url: baseURL + '/orders/searchOrder',
            type: 'POST',
            data: {
                search,
                activeId
            },
            datatype: 'json',
            success: function (response) {
                $('#order-list-data-div').html(response)
                $('.foodorder-box-details ').html('')
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })
})

function orderDetail(id) {
    $.ajax({
        url: baseURL + '/orders/order-detail/' + id,
        type: 'GET',
        success: function (response) {
            $('.foodorder-box-details').html(response);

            $(".foodorder-box-list div").removeClass("active");
            $('#order-' + id).addClass('active');
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
$('#expiry_date').daterangepicker({
    maxDate: new Date(),
    ranges: {
       'Today': [moment(), moment()],
       'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Last 7 Days': [moment().subtract(6, 'days'), moment()],
       'Last 30 Days': [moment().subtract(29, 'days'), moment()],
       'This Month': [moment().startOf('month'), moment().endOf('month')],
       'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
});

$('#expiry_date').val('')
$('#expiry_date').attr('placeholder','Select Date Range')

$('#expiry_date').on('apply.daterangepicker', function(ev, picker) {

    dateRange = $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));

    var start_date = picker.startDate.format('DD/MM/YYYY');
    var end_date = picker.endDate.format('DD/MM/YYYY');

    value = "start_date="+ start_date + "&end_date=" + end_date;

    window.location.href = `${baseURL}/orders?${value}`;
});

$('#expiry_date').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
});

$('#clear').on("click",function()
{
window.location.href = `${baseURL}/orders`;
});


 // Get start and end dates from URL parameters
 var startDate = getUrlParameter('start_date');
 var endDate = getUrlParameter('end_date');

if (startDate && endDate) {
    $('#expiry_date').data('daterangepicker').setStartDate(moment(startDate, 'MM/DD/YYYY'));
    $('#expiry_date').data('daterangepicker').setEndDate(moment(endDate, 'MM/DD/YYYY'));
    $('#expiry_date').val(startDate + ' - ' + endDate);
}


function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}