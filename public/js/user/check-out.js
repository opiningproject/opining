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
        var paymentType = $(this).data('type')
        var paymentBtnText = ''

        // 1-Card, 2-Cash, 3-Idle
        if(paymentType == '1'){
            paymentBtnText = 'Card'
        }else if(paymentType == '2'){
            paymentBtnText = 'Cash'
        }else{
            paymentBtnText = 'iDEAL'
        }
        $('#payment_type').val(paymentType)
        $('#total-amt-pay-btn').text(paymentBtnText)
    })

    $('.cardNumber').keypress(function (e) {
        var charCode = (e.which) ? e.which : event.keyCode

        if (String.fromCharCode(charCode).match(/[^0-9]/g)) {
            return false;
        }
        if($(this).val().length < 19){
            let value = $(this).val().replace(/\s/g, '');

            // Update the input value with space after every 4 digits
            $(this).val(value.replace(/(\d{4})/g, '$1 '));
        }else{
            return false
        }

    })

    $('.expireYear').keypress(function (e) {
        var charCode = (e.which) ? e.which : event.keyCode

        if (String.fromCharCode(charCode).match(/[^0-9]/g)) {
            return false;
        }
        if($(this).val().length < 5){
            if ($(this).val().length == 2) {
                $(this).val($(this).val() + '/');
            }
        }else{
            return false
        }

    })
});
