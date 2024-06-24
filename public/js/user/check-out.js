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

if(isDesktopView()) {
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
} else {
    $('#delivery-mobile-content').toggle()
    $('#delivery-user-mobile-content').toggle()
    $("#final-checkout-form").validate({
        ignore: '[readonly]',
        errorPlacement: function(error, element) {

            if(element[0].id == 'street_name' || element[0].id == 'house_no' || element[0].id == 'city' || element[0].id == 'first_name' || element[0].id == 'last_name' || element[0].id == 'email' || element[0].id == 'phone_no') {
                let ret = element[0].id
                .split("_")
                .filter(x => x.length > 0)
                .map((x) => (x.charAt(0).toUpperCase() + x.slice(1)))
                .join(" ");

                if(element[0].id == 'phone_no') {

                    let phone_error = element[0].value == '' ? "Please fill " + ret.toLowerCase() +" in address detail." : error[0].outerText;
                    $(".success-ico.success-address").hide();
                    $("#deliviery-address-error").text(phone_error);
                } else {
                    $(".success-ico.success-address").hide();
                    $("#deliviery-address-error").text("Please fill " + ret.toLowerCase() +" in address detail.");
                }
                return false
            } else {
                $("#deliviery-address-error").text("");
                $(".success-ico.success-address").show();
            }

            if(element[0].id == 'card_name' || element[0].id == 'cvv' || element[0].id == 'exp_date') {
                let ret = element[0].id
                .split("_")
                .filter(x => x.length > 0)
                .map((x) => (x.charAt(0).toUpperCase() + x.slice(1)))
                .join(" ");

                    $("#payment-method-error").text("Please fill " + ret.toLowerCase() +" in card details.");
                    $(".success-ico.success-payment-method").hide();
                return false
            } else {
                    $("#payment-method-error").text("");
                    $(".success-ico.success-payment-method").show();
            }



            error.insertAfter(element)
            $('#all-validation-error').show()
        },
        submitHandler: function (form) {
            $('#all-validation-error').hide()
            addOrder()
        }
    });
    // $("#final-checkout-form").on("submit", function (event) {
    //     event.preventDefault();
    //     addOrder();
    // });
}

   

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


function checkScreenSize() {
    if ($(window).width() <= 767) {
        $('body').addClass('title-becomes');
    } else {
        $('body').removeClass('title-becomes');
    }
}

function checkScreenSize1() {
    if ($(window).width() <= 767) {
        $('body').removeClass('title-becomes');
    } else {
        $('body').addClass('title-becomes');
    }
}

// Add event listener for window resize
$(window).on('resize', checkScreenSize);

$(document).on('click','#menu-sidebar', function () {
    checkScreenSize();
});
$(document).on('click','#menu-sidebar-close', function () {
    checkScreenSize1();
});
