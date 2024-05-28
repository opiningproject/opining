$(function () {
    $(document).on('keyup', '#search-order', function () {
        var search = $(this).val();
        // var activeId = $('.foodorder-box-list-item').getActiv

        $.ajax({
            url: baseURL + '/orders/searchOrder',
            type: 'POST',
            data: {
                search
            },
            datatype: 'json',
            success: function (response) {
                $('#order-list-data-div').html(response)
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
