$(function () {

    // checkout button enables disable as per client feeedback july 2024 CR points
    var min_order_price = $('.min_order_price').html()
    var currentAmount = $('.bill-count').html()

    // var currentAmount = $('.bill-total-count').html()
    // if(!zipcode) {
    //     $('#delivery-charge-tab').hide()
    // }
    if (currentAmount) {
        currentAmount = currentAmount.replace('€', '')
        if (parseFloat(currentAmount) >= parseFloat(min_order_price)) {
            $('.checkout-sticky-btn').removeClass('show-hide-btn');
        } else {
            $('.checkout-sticky-btn').addClass('show-hide-btn');
        }
        if ($('.TakeAway-tab .active').length == 0) {
            $('.minimum_amount').show();
        } else {
            $('.minimum_amount').hide();
            $('.checkout-sticky-btn').removeClass('show-hide-btn');
        }
    }

    var url = baseURL + '/user/dashboard';

    $("#delivery-add-form").validate({
        rules:{
            zipcode: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
            house_no: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
        },
        submitHandler: function (form) {
            validateZipcode();
            //window.location.href = url;
        }
    });

    $("#take-away-add-form").validate({
        submitHandler: function (form) {
            // window.location.href = url;
            addTakeawayPhone()
        }
    });

    $("#address-form").validate({
        rules:{
            zipcode: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
            house_no: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
        },
        submitHandler: function (form) {
            validateZipcode()
        }
    });

    $("#address-form-mobile").validate({
        rules:{
            zipcode: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
            house_no: {
                alphaNumericalRegex: "^[a-zA-Z0-9]+$"
            },
        },
        submitHandler: function (form) {
            console.log("Validation passed");
            console.log($.fn.validate ? "Validation loaded" : "Validation not loaded");

            validateZipcodeMobile()
        }
    });

    $('#addressChangeModal').on('hidden.bs.modal', function () {
        var alertas = $('#address-form');
        alertas.trigger("reset");
        alertas.validate().resetForm();

        $("#zipcode-error").addClass('d-none');
    });

    /*$(document).on('click', '.select-address-btn', function () {
        console.log("select-address-btn")
        var parentId = $(this).closest('div[id^="address-"]').attr('id');

        // Extract the address ID from the parent div's ID
        var addressId = parentId.split('-')[1];


        var $parentDiv = $(this).closest('.total-addresses');
        // Hide the delete button in the clicked address div
        $parentDiv.find('.delete-address').addClass('d-none');

        // Show the delete button in all other address divs
        $('.total-addresses').not($parentDiv).find('.delete-address').removeClass('d-none');

        // Update the button text based on the address ID
        // $(this).text('Selected');

        // Change the text of other buttons to 'Deliver Here' and remove styples except the clicked one

        $('.selected-address').html('<span class="success-ico blank"></span>');
        // $('.select-address-btn').not($(this)).attr('style', '');



        // var dynamicStyle = 'pointer-events:none; cursor:default;';
        // $(this).attr('style', dynamicStyle);

        $.ajax({
            url: baseURL + '/user/validate-address/' + addressId,
            type: 'GET',
            success: function (response) {

                $('#zipcode').val(response.data.zipcode)
                $('#house_no').val(response.data.house_no)
                $('#city').val(response.data.city)
                $('#street_name').val(response.data.street_name)
                if (response.status == 406) {

                    $('#zipcode-error').text(response.data.message);
                    $('#zipcode-error').css("display", "block");
                } else {

                    $('#selected-address-'+addressId).html('<span class="success-ico"><img src="/images/success-icon.svg" class="svg" width="14" height="11"></span>');

                    let houseNumber = response.data.house_no;
                    let zipcode = response.data.zipcode;
                    let city = response.data.city;
                    let street_name = response.data.street_name;
                    let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                    if (street_name) {
                        displayText = street_name + ' ' + houseNumber ;
                    }

                    $("#zip_address").html('');
                    $("#zip_address").html('<p class="mb-0">' + displayText + '</p>');

                    // checkout button enables disable as per client feeedback july 2024 CR points
                    $('.minimum_amount').html('<span class="minimum_amounts">'+ '(minimum €'+response.data.min_order_price.toFixed(2) +')</span>')
                    $('.min_order_price').html(response.data.min_order_price.toFixed(2))
                    var min_order_price = response.data.min_order_price

                    if(response.data.delivery_charge) {
                        let currentAmount = $('#total-cart-bill').html()
                        currentAmount = currentAmount.replace('€', '')
                        $('#delivery-charge-tab').show()
                        $('.delivery_charge_amount').html('<span class="bill-count delivery_charge_amount">€'+response.data.delivery_charge.toFixed(2) +'</span>')
                        $('#delivery-charge').val(response.data.delivery_charge.toFixed(2))
                        let amount = parseFloat(currentAmount)

                        amount += response.data.delivery_charge;
                        let serviceCharge = $('#service-charge').val()
                        if( serviceCharge) {
                            amount += parseFloat(serviceCharge);
                        }
                        $('#gross-total-bill').text('€' + amount.toFixed(2))
                        $('#gross-total-bill1').text('€' + amount.toFixed(2))
                    }

                    if (parseFloat(currentAmount) >= parseFloat(min_order_price)) {
                        $('.checkout-sticky-btn').removeClass('show-hide-btn');
                    } else {
                        $('.checkout-sticky-btn').addClass('show-hide-btn');
                    }

                    $('#addressChangeModal').modal('hide');

                    $('#addressChangeModal').on('hidden.bs.modal', function () {
                        $('#zipcode').val(response.data.zipcode)
                        $('#house_no').val(response.data.house_no)
                        $('#city').val(response.data.city)
                        $('#street_name').val(response.data.street_name)
                    });

                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })*/
    function handleAddressSelection(addressId, $parentDiv, $thisBtn) {
        // Hide the delete button in the clicked address div
        $parentDiv.find('.delete-address').addClass('d-none');

        // Show the delete button in all other address divs
        $('.total-addresses').not($parentDiv).find('.delete-address').removeClass('d-none');

        // Clear the selected address icon
        $('.selected-address').html('<span class="success-ico blank"></span>');

        $.ajax({
            url: baseURL + '/user/validate-address/' + addressId,
            type: 'GET',
            success: function (response) {
                $('#zipcode').val(response.data.zipcode);
                $('#house_no').val(response.data.house_no);
                $('#city').val(response.data.city);
                $('#street_name').val(response.data.street_name);

                if (response.status == 406) {
                    $('#zipcode-error').text(response.data.message);
                    $('#zipcode-error').css("display", "block");
                } else {
                    $('#selected-address-' + addressId).html('<span class="success-ico"><img src="/images/success-icon.svg" class="svg" width="14" height="11"></span>');

                    let houseNumber = response.data.house_no;
                    let zipcode = response.data.zipcode;
                    let city = response.data.city;
                    let street_name = response.data.street_name;
                    let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                    if (street_name) {
                        displayText = street_name + ' ' + houseNumber;
                    }

                    $("#zip_address").html('<p class="mb-0">' + displayText + '</p>');
                    $("#zip_address_mobile").html('<p class="mb-0">' + displayText + '</p>');

                    // Update minimum amount and delivery charge logic
                    $('.minimum_amount').html('<span class="minimum_amounts">' + '(minimum €' + response.data.min_order_price.toFixed(2) + ')</span>');
                    $('.min_order_price').html(response.data.min_order_price.toFixed(2));

                    let min_order_price = response.data.min_order_price;
                    let currentAmount = $('#total-cart-bill').html().replace('€', '');

                    if (response.data.delivery_charge) {
                        $('#delivery-charge-tab').show();
                        $('.delivery_charge_amount').html('<span class="bill-count delivery_charge_amount">€' + response.data.delivery_charge.toFixed(2) + '</span>');
                        $('#delivery-charge').val(response.data.delivery_charge.toFixed(2));

                        let amount = parseFloat(currentAmount) + response.data.delivery_charge;
                        let serviceCharge = $('#service-charge').val();

                        if (serviceCharge) {
                            amount += parseFloat(serviceCharge);
                        }

                        $('#gross-total-bill').text('€' + amount.toFixed(2));
                        $('#gross-total-bill1').text('€' + amount.toFixed(2));
                    }

                    if (parseFloat(currentAmount) >= parseFloat(min_order_price)) {
                        $('.checkout-sticky-btn').removeClass('show-hide-btn');
                    } else {
                        $('.checkout-sticky-btn').addClass('show-hide-btn');
                    }

                    $('#addressChangeModal').modal('hide');
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message;
                alert(errorMessage);
            }
        });
    }

    $(document).on('click', '.select-address-btn', function () {
        var parentId = $(this).closest('div[id^="address-"]').attr('id');
        var addressId = parentId.split('-')[1];
        var $parentDiv = $(this).closest('.total-addresses');

        // Call the common function to handle the selection
        handleAddressSelection(addressId, $parentDiv, $(this));
        $('.addressError').addClass('d-none')
    });




    $('input[name="selected_address"]').on('change', function() {
        var selectedAddress = $(this).closest('div[id^="address-mobile-"]').attr('id');
        var addressId = selectedAddress.split('-')[2];
        console.log('Selected address ID:', selectedAddress, addressId);

        // Get the parent div for the selected address
        var $parentDiv = $(this).closest('.total-addresses');

        // Call the handleAddressSelection function
        handleAddressSelection(addressId, $parentDiv, $(this));
        $('.addressError').addClass('d-none')
        // Perform any additional logic such as form submission or updating the UI.
    });

    $.validator.addMethod(
        "alphaNumericalRegex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        validationMsg.alpha_numeric
    );
});


function validateZipcode() {
    var zipcode = $('#zipcode').val();
    var house_no = $('#house_no').val();

    var url = baseURL + '/user/dashboard';

    $.ajax({
        url: baseURL + '/validateZipcode',
        type: 'POST',
        data: {
            zipcode, house_no
        },
        success: function (response) {

            if (response.status == 2) {
                $('#zipcode-error').text(response.message);
                $('#zipcode-error').css("display", "block");
            } else {
            let currentUrl = window.location.href;

            if(url !== currentUrl) {
                window.location.href = url;
            } else {
                if(response.zipcode && response.house_number) {

                    let houseNumber = response.house_number;
                    let zipcode = response.zipcode;
                    let city = response.city;
                    let street_name = response.street_name;
                    let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                    if (street_name) {
                        displayText = street_name + ' ' + houseNumber ;
                    }
                    $("#zip_address").html('');
                    $("#zip_address").html('<p class="mb-0">' + displayText + '</p>');
                    $("#zip_address_mobile").html('');
                    $("#zip_address_mobile").html('<p class="mb-0">' + displayText + '</p>');
                    $('#addressChangeModal').modal('hide');

                    // After closing modal set updated values
                    $('#addressChangeModal').on('hidden.bs.modal', function () {
                        $('#house_no').val(response.house_number)
                        $('#zipcode').val(response.zipcode)

                        // checkout button enables disable as per client feeedback july 2024 CR points
                        $('.min_order_price').html(response.min_order_price.toFixed(2))
                        var min_order_price = $('.min_order_price').html()
                        // var currentAmount = $('.bill-total-count').html()
                        var currentAmount = $('.bill-count').html()

                        currentAmount = currentAmount.replace('€', '')
                        if (parseFloat(currentAmount) >= parseFloat(min_order_price)) {
                            $('.checkout-sticky-btn').removeClass('show-hide-btn');
                        } else {
                            $('.checkout-sticky-btn').addClass('show-hide-btn');
                        }
                        $('.minimum_amount').show();
                        $('.minimum_amount').html('<span class="minimum_amounts">'+ 'minimum €' + response.min_order_price.toFixed(2) +'</span>')
                    });
                }
                }
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function addTakeawayPhone() {

    var phone_no = $('#phone_no').val();

    $.ajax({
        url: baseURL + '/takeawayPhone',
        type: 'POST',
        data: {
            phone_no
        },
        success: function (response) {
            window.location.href = baseURL + '/user/dashboard';
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function deleteAddress(id) {
    $.ajax({
        url: baseURL + '/user/delete-address/' + id,
        type: 'GET',
        success: function (response) {
            $('#address-' + id).remove();

            var mainDiv = $('#addresses-length');
            // Find all div elements inside the main div
            var childDivs = mainDiv.find('.total-addresses');
            // Get the length of child divs
            var numberOfChildDivs = childDivs.length;
            // If there is only one child div, hide the delete button inside it
            if (numberOfChildDivs === 1) {
                childDivs.find('.delete-address').hide();
                $('#address-' + id).remove();
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

//for mobile address design
function validateZipcodeMobile() {
    var zipcode = $('#zipcode_mobile').val();
    var house_no = $('#house_no_mobile').val();
    console.log("innn")
    var url = baseURL + '/user/dashboard';

    $.ajax({
        url: baseURL + '/validateZipcode',
        type: 'POST',
        data: {
            zipcode, house_no
        },
        success: function (response) {

            if (response.status == 2) {
                $('#zipcode-error').text(response.message);
                $('#zipcode-error').css("display", "block");
            } else {
                let currentUrl = window.location.href;

                if(url !== currentUrl) {
                    window.location.href = url;
                } else {
                    if(response.zipcode && response.house_number) {

                        let houseNumber = response.house_number;
                        let zipcode = response.zipcode;
                        let city = response.city;
                        let street_name = response.street_name;
                        let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                        if (street_name) {
                            displayText = street_name + ' ' + houseNumber ;
                        }
                        $("#zip_address").html('');
                        $("#zip_address").html('<p class="mb-0">' + displayText + '</p>');
                        $("#zip_address_mobile").html('');
                        $("#zip_address_mobile").html('<p class="mb-0">' + displayText + '</p>');
                        $('#addressChangeModal').modal('hide');

                        // After closing modal set updated values
                        // $('#addressChangeModal').on('hidden.bs.modal', function () {
                            $('#house_no_mobile').val(response.house_number)
                            $('#zipcode_mobile').val(response.zipcode)

                            // checkout button enables disable as per client feeedback july 2024 CR points
                             $('.min_order_price').html(response.min_order_price.toFixed(2))
                            var min_order_price_mobile = response.min_order_price.toFixed(2)
                            // var currentAmount = $('.bill-total-count').html()
                            var currentAmountMobile = $('.bill-count').html()

                            currentAmountMobile = currentAmountMobile.replace('€', '')
                        console.log("currentAmountMobile", currentAmountMobile, "min_order_price_mobile", min_order_price_mobile)
                            if (parseFloat(currentAmountMobile) >= parseFloat(min_order_price_mobile)) {
                                $('.checkout-sticky-btn').removeClass('show-hide-btn');
                            } else {
                                $('.checkout-sticky-btn').addClass('show-hide-btn');
                            }
                            $('.minimum_amount').show();
                            $('.minimum_amount').html('<span class="minimum_amounts">'+ 'minimum €' + response.min_order_price.toFixed(2) +'</span>')
                        // });
                        // $('.minimum_amount').show();
                        // $('.minimum_amount').html('<span class="minimum_amounts">'+ '(minimum €' + response.min_order_price.toFixed(2) +')</span>')
                    }
                }
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
