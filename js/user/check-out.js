$(function () {

    $('.radio-del-time').click(function () {

        if ($(this).val() == 'asap') {
            $('.customize-time-div').hide()
        } else {
            $('.customize-time-div').show()
        }
    })

    $("#final-checkout-form").validate({
        submitHandler: function (form) {
            addOrder()
        }
    });

    $('.payment-type-tab').click(function () {
        $('#payment_type').val($(this).data('type'))
    })
});

async function addOrder() {

    var streetName = $('#street_name').val()
    var houseNo = $('#house_no').val()
    var city = $('#city').val()
    var address = houseNo + ' ' + streetName + ' ' + city

    var geocoder = new google.maps.Geocoder();
    var latitude = ''
    var longitude = ''
    await geocoder.geocode( { 'address': address}, function(results, status) {

        if (status == google.maps.GeocoderStatus.OK) {
            latitude = results[0].geometry.location.lat();
            longitude = results[0].geometry.location.lng();
            console.log('longitude 1',longitude)
            console.log('latitude 2',latitude)
        }
    });

    var checkoutData = new FormData(document.getElementById('final-checkout-form'))
    checkoutData.append('longitude', longitude)
    checkoutData.append('latitude', latitude)

    await $.ajax({
        url: baseURL+'/user/place-order-cod',
        type: 'POST',
        processData: false,
        contentType: false,
        data: checkoutData,
        success(response){
            if(response.status == 200){
                window.location.replace(baseURL+'/user/orders')
            }else{
                alert(response.message)
            }
        },
        error(response){

        }
    })
}
