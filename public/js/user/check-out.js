$(function () {

    $('.radio-del-time').click(function () {

        if ($(this).val() == 'asap') {
            $('#del-type-mobile-text').text(validationMsg.asap)
            $('.customize-time-div').hide()
        } else {
            $('#del-type-mobile-text').text(validationMsg.customize_time)
            $('.customize-time-div').show()
        }
    })

    $("#final-checkout-form").validate({
        ignore: '[readonly]',
        errorPlacement: function(error, element) {
            error.insertAfter(element)
            $('#all-validation-error').show()
        },
        submitHandler: function (form) {
            $('#all-validation-error').hide()
            addOrder()
        }
    });

    $('.payment-type-tab').click(function () {
        var paymentType = $(this).data('type')
        var paymentBtnText = ''

        // 1-Card, 2-Cash, 3-Idle
        if(paymentType == '1'){
            $('.card-validate').attr('readonly', false)
            paymentBtnText = validationMsg.card
        }else if(paymentType == '2'){
            $('.card-validate').attr('readonly', true)
            paymentBtnText = validationMsg.cash
        }else{
            $('.card-validate').attr('readonly', true)
            paymentBtnText = validationMsg.ideal
        }
        $('#payment_type').val(paymentType)
        $('#total-amt-pay-btn').text(paymentBtnText)
        $('#mobile-payment-type-text').text(paymentBtnText)
    })

    $(document).on('keypress keydown','.cardNumber', function (e){
    /*
    })
    $('.cardNumber').keypress(function (e) {*/
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

    $(document).on('keypress keydown', '.expireYear', function (e){
    /*})
    $('.expireYear').keypress(function (e) {*/
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

    $('#delivery-info-tab').click(function (){
        $('#delivery-mobile-content').toggle()
        $('#delivery-user-mobile-content').toggle()
    })

    $('#delivery-time-tab').click(function (){
        $('#delivery-type-mobile-content').toggle()
    })

    $('#payment-type-mobile-tab').click(function (){
        $('#payment-type-mobile-content').toggle()
    })
});
