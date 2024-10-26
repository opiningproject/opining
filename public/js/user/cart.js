var distance = $('.content-main-part').offset().top;
var invoiceHeight = $('.cartSidebarCustom .bill-detail-invoice').height();

function addPaddingToCouponTag(type,newHeight) {
    if(invoiceHeight) {
        if (type == "2") {
            $('.cartSidebarCustom .cartoffCanvas').css('padding-bottom', newHeight + 'px');
        } else {
            $('.cartSidebarCustom .cartoffCanvas').css('padding-bottom', newHeight + 'px');
        }
    }
}

$(function () {
    toastr.options = {
        "backgroundColor": "#ff0000" // Set your desired background color here
    }
    scrollableIcon()

    $(window).scroll(function() {
        scrollableIcon()
    });

    $('.pills-delivery-tab').click(function () {
        var type = $(this).data('type')

        if (type == "2") {
            let newHeights = invoiceHeight + 15;

            addPaddingToCouponTag(type,newHeights)
            $('.minimum_amount').hide()
            $('.desktop-pill-home').removeClass('show active')
            $('.desktop-pill-home').addClass('d-none');
            $('.desktop-pill-takeAway').addClass('show active')

            $('.delivery-tab-mobile').addClass('d-none')
            $('.takeAway-tab-mobile').removeClass('d-none')
            $("#zip_address_mobile_takw_away").removeClass('d-none');
            $("#zip_address_mobile").addClass('d-none');
            $('.addressError').addClass('d-none');
            $(".zipcode-error-mobile").addClass('d-none');
            // console.log($('.takeAway-tab-mobile-address').text())
        } else {
            let newHeight = invoiceHeight + 15;

            addPaddingToCouponTag(type,newHeight)
            $('.minimum_amount').show()
            $('.desktop-pill-home').addClass('show active');
            $('.desktop-pill-home').removeClass('d-none');

            $('.desktop-pill-takeAway').removeClass('show active')
            $('.delivery-tab-mobile').removeClass('d-none')
            $('.takeAway-tab-mobile').addClass('d-none')
            // $("#zip_address_mobile").html('');
            $("#zip_address_mobile_takw_away").addClass('d-none');
            $("#zip_address_mobile").removeClass('d-none');
            if ($('#zip_address_mobile').text().trim() === '') {
                $('.addressError').removeClass('d-none');
            } else {
                $('.addressError').addClass('d-none');
            }
        }

        var zipcode = $('#del-zipcode').val()
        var houseNo = $('#del-house-no').val()

        $.ajax({
            type: 'PATCH',
            url: baseURL + '/user/cart/update-delivery-type',
            data: {
                type,
                zipcode,
                houseNo
            },
            success: function (response) {

                if (response.status == 200) {
                    // checkout button enables disable as per client feeedback july 2024 CR points
                    var min_order_price = $('.min_order_price').html()
                    var currentAmount = $('.bill-total-count').html()
                    currentAmount = currentAmount.replace('€', '')

                    let total_amount = parseFloat(currentAmount)

                    if (type == '1') {


                        var itemTotal = $('.bill-count').html()
                        itemTotal = itemTotal.replace('€', '')

                        if (parseFloat(itemTotal) >= parseFloat(min_order_price)) {
                            $('.checkout-sticky-btn').removeClass('show-hide-btn');
                        } else {
                            $('.checkout-sticky-btn').addClass('show-hide-btn');
                        }
                        $('#delivery-charge-tab').show()
                        // Hide as per client feeedback June CR points
                        // $('#addressChangeModal').modal('show')

                        let del_charge = $('.delivery_charge_amount').text()
                        del_charge = del_charge.replace('€', '')

                        if(del_charge) {
                            total_amount += parseFloat(del_charge);
                            $('#gross-total-bill').text('€' + total_amount.toFixed(2))
                            $('#gross-total-bill1').text('€' + total_amount.toFixed(2))
                        }
                    } else {
                        let del_charge = $('.delivery_charge_amount').text()
                        del_charge = del_charge.replace('€', '')

                        if(del_charge) {
                            total_amount -= parseFloat(del_charge);
                            $('#gross-total-bill').text('€' + total_amount.toFixed(2))
                            $('#gross-total-bill1').text('€' + total_amount.toFixed(2))
                        }
                        $('#delivery-charge-tab').hide()

                        $('.checkout-sticky-btn').removeClass('show-hide-btn');
                    }
                } else {
                    // alert(response.message);
                    toastr.error(response.message);
                }
            },
            error: function (response) {

                if (response.status == 401) {
                    $('#signInModal').modal('show');
                } else {
                    var errorMessage = JSON.parse(response.responseText).message
                    toastr.error(errorMessage)
                    // alert(errorMessage);
                }
            }
        })
    })

    $('#checkout-cart').click(function () {
        var totalAmt = $('#total-cart-bill-amount').val()

        $.ajax({
            url: baseURL + '/user/validate-cart',
            type: 'POST',
            data: {
                totalAmt
            },
            success: function (response) {
                $("#coupon-code-error").addClass('d-none');
                $('#coupon-code-error').text('');
                if (response.status == 400) {
                    $('#addressChangeModal').modal('show')
                } else if (response.status == 200) {
                    window.location.replace(baseURL + '/user/checkout')
                } else {
                    console.log("response", response.restaurant_closed == 'true')
                    if (response.restaurant_closed == 'true') {
                        toastr.error(response.message);
                    }
                    // alert(response.message);
                    var errorOccurred = true; // Replace this with actual error detection logic
                    if (errorOccurred) {
                        var targetElement = $('.pills-home');
                        // Check if the shake class is already present
                        if (!targetElement.hasClass('shake')) {
                            // Add the shake class to the element
                            targetElement.addClass('shake');
                            // Scroll to the element inside the .offcanvas-body container
                            var scrollableContainer = $('.offcanvas-body');
                            scrollableContainer.animate({
                                scrollTop: scrollableContainer.scrollTop() + scrollableContainer.offset().top - scrollableContainer.offset().top
                            }, 500);
                            $('.cart-sidebar .cart-address-row').css('box-shadow', 'rgba(0, 0, 0, 0.15) 1px 2px 10px 8px');

                            // Remove the shake class after the animation completes (0.5s)
                            setTimeout(function() {
                                targetElement.removeClass('shake');
                                $('.cart-sidebar .cart-address-row').css('box-shadow', '1px 2px 10px 8px rgba(0, 0, 0, 0.08)');
                            }, 500);
                            $('.addressError').removeClass('d-none');
                        }
                    }
                    if ($(window).width() <= 767) {
                        toastr.error(response.message);
                        $('#zip_address_mobile').html('');
                    }
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $('.remove-cart-dish').click(function () {
        var id = $(this).data('id')

        $.ajax({
            url: baseURL + '/user/cart/remove-dish/' + id,
            type: 'DELETE',
            success: function (response) {
                if (response.status == 200) {
                    $('#cart-' + id).remove()
                    calculateTotalCartAmount()
                } else {
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $(document).on('focusout','.dish-notes',function () {
        var notes = $(this).val()
        var id = $(this).data('id')

        $.ajax({
            url: baseURL + '/user/cart/update-notes/' + id,
            type: 'PATCH',
            data: {
                notes
            },
            success: function (response) {
                if (response.status != 200) {
                    // alert(response.message);
                    toastr.warning(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $('#delivery_instruction').focusout(function () {
        var delivery_notes = $(this).val()

        $.ajax({
            url: baseURL + '/user/cart/update-del-ins/',
            type: 'PATCH',
            data: {
                delivery_notes
            },
            success: function (response) {
                if (response.status != 200) {
                    toastr.warning(response.message);
                    // alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })
});

function scrollableIcon(){
    if ($(window).scrollTop() > distance ) {
        $('.bottom-sticky').show()
    } else {
        $('.bottom-sticky').hide()
    }
}

function addToCart(id) {
    $.ajax({
        url: baseURL + '/user/add-to-cart/' + id,
        type: 'GET',
        success: function (response) {

            if (response.status == 2) {
                $('#signInModal').modal('show');
                return false;
            }

            $("#dish-cart-lbl-" + id).text('Added to cart');
            $("#dish-cart-lbl-" + id).prop('disabled', true);
            $('.cart-items').append(response);
            $('#cart-amount-cal-data').show()

            $('#empty-cart-div').hide()
            $('#checkout-cart').removeClass('d-none')
            $('#cart-bill-div').removeClass('d-none')
            $('#qty-' + id).attr('data-ing', 0)
            calculateTotalCartAmount()

            $('#cart-item-count').text(parseInt($('#cart-item-count').text()) + 1)
            $('#cart-count-sticky').text(parseInt($('#cart-count-sticky').text()) + 1)
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);;
        }
    })
}

function updateDishQty(operator, maxQty, dish_id) {
    var current_qty = parseInt($('input[name=qty-' + dish_id + ']').val());

    if (operator == '-' && !isNaN(current_qty) && current_qty > 0) {
        $('input[name=qty-' + dish_id + ']').val(current_qty - 1);
        $('#quantity-'+ dish_id).text(current_qty - 1);
    }

    if (operator == '+' && !isNaN(current_qty)) {
        /*if (current_qty >= maxQty) {
            toastr.error(validationMsg.quantity_error)
            return false;
        }*/

        $('input[name=qty-' + dish_id + ']').val(current_qty + 1);
        $('#quantity-'+ dish_id).text(current_qty + 1);
    }

    var current_qty = parseInt($('input[name=qty-' + dish_id + ']').val());

    $.ajax({
        type: 'POST',
        url: baseURL + '/user/update-dish-qty',
        data: {
            dish_id, operator, current_qty
        },
        success: function (response) {

            if (response.status == 1 && parseInt(current_qty) == 0) {
                $("#cart-" + dish_id).remove();
                $('#cart-item-count').text(parseInt($('#cart-item-count').text()) - 1)
                $('#cart-count-sticky').text(parseInt($('#cart-count-sticky').text()) - 1)
                $("#dish-cart-lbl-" + dish_id).text('Add +');
                $("#dish-cart-lbl-" + dish_id).prop('disabled', false);

                if ($('.cart-amt').length > 0) {
                    $('#empty-cart-div').hide()
                    $('#checkout-cart').removeClass('d-none')
                    $('#cart-bill-div').removeClass('d-none')
                } else {
                    $('#empty-cart-div').show()
                    $('#checkout-cart').addClass('d-none')
                    $('#cart-bill-div').addClass('d-none')
                    $('#cart-amount-cal-data').hide()
                }

                if (response.message) {
                    $("#coupon_code_apply_btn").show();
                    $("#coupon_code_remove_btn").hide();
                    $('#coupon_code').val('');
                    $("#coupon_code").prop('readonly', false);
                    $('#coupon-discount').val(0)
                    $('#coupon-discount-percent').val(0.0)
                    $('#coupon-discount-text').val('-€0')
                    $('#item-discount').hide()
                    calculateTotalCartAmount()
                }

            }

            $('#paid-ing-price' + dish_id).text('+€' + (parseFloat($('#qty-' + dish_id).val()) * parseFloat($('#qty-' + dish_id).attr('data-ing'))).toFixed(2))
            calculateTotalCartAmount()
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);;
        }
    })
}

function applyCoupon() {
    var couponCode = $('#coupon_code').val();
    var orderAmount = $('#total-cart-bill-amount').val();

    if (couponCode == '') {
        $("#coupon-code-error").removeClass('d-none');
        $('#coupon-code-error').text(validationMsg.enter_coupon);
        return;
    }

    $.ajax({
        type: 'POST',
        url: baseURL + '/user/coupon/apply',
        data: {
            couponCode,
            orderAmount
        },
        success: function (response) {

            if ($('.TakeAway-tab .active').length == 0) {
               let newHeight = invoiceHeight + 30;
               addPaddingToCouponTag(1,newHeight)
            } else {
                let newHeight = invoiceHeight - 18;
                addPaddingToCouponTag(2,newHeight)
            }

            if (response.status == 200) {
                $("#coupon_code_remove_btn").show();
                $("#coupon_code_apply_btn").hide();
                $("#coupon_code").prop('readonly', true);

                $("#coupon-code-error").addClass('d-none');
                $('#coupon-code-error').text('');

                $('#coupon-discount-text').text('-€' + response.data.discount_amount)
                $('#coupon-discount').val(response.data.discount_amount)
                $('#coupon-discount-percent').val(response.data.coupon_percent)
                $('#item-discount').show()
                calculateTotalCartAmount()
            } else {
                $("#coupon-code-error").removeClass('d-none');
                $('#coupon-code-error').text(response.message);
                $('#coupon-discount-percent').val(0)
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);;
        }
    })
}

function removeCoupon() {

    $.ajax({
        type: 'PATCH',
        url: baseURL + '/user/remove-coupon',
        success: function (response) {
            if (response.status == 200) {
                $("#coupon_code_apply_btn").show();
                $("#coupon_code_remove_btn").hide();
                $('#coupon_code').val('');
                $("#coupon_code").prop('readonly', false);
                $('#coupon-discount').val(0)
                $('#coupon-discount-percent').val(0.0)
                $('#coupon-discount-text').val('-€0')
                $('#item-discount').hide()
                calculateTotalCartAmount()
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);;
        }
    })
}

function addSubDishQuantities(dishId, operator, maxQty) {
    var dishAmt = $('#dish-org-price').val()
    var currentQty = parseInt($('input[name=qty-' + dishId + ']').val());

    if (operator == '-') {
        if (currentQty != 1) {
            $('input[name=qty-' + dishId + ']').val(currentQty - 1);
            updateCartAmount(dishId, dishAmt, 'sub', 1)
        }
    }

    if (operator == '+') {
        /*if (currentQty >= maxQty) {
            toastr.error(validationMsg.quantity_error)
            return false;
        }*/

        $('input[name=qty-' + dishId + ']').val(currentQty + 1);
        updateCartAmount(dishId, dishAmt, 'add', 1)
    }
}

function addSubDishIngredientQuantities(IngDishId, operator, dishId) {

    var currentQty = parseInt($('#dishIng' + IngDishId).val());
    var amount = parseFloat($('#ing-price-val' + IngDishId).text().replace(/,/g, ''))
    var totalDishQty = parseInt($('#totalDishQty').val())

    if (operator == '-') {
        if (currentQty != 0) {
            $('#dishIng' + IngDishId).val(currentQty - 1);
            updateCartAmount(dishId, (amount * totalDishQty), 'sub')
        }
    }

    if (operator == '+') {
        $('#dishIng' + IngDishId).val(currentQty + 1);
        updateCartAmount(dishId, (amount * totalDishQty), 'add')
    }
}

function addDishOptionPrice(dishId,amount) {
    var totalAmount = 0
    var lastAmount = 0 ;
    var ingAmount = 0.00

        if ($('.dishPaidIngQty').length) {
            $('.dishPaidIngQty').each(function (index, element) {
                if ($(element).val() > 0) {
                    ingAmount += parseFloat($(element).data('price')) * parseInt($(element).val())
                }
            })
        }
    $('.dish-option-select').each(function () {
        let selectedOption = $(this).find('option:selected');
        let amount = parseFloat(selectedOption.data('price')) || 0;
        totalAmount += amount;
    });
    let currentVal = parseFloat($('#total-amt' + dishId).text().replace(/,/g, '')) || 0;
    if (lastAmount > 0 ) {
        currentVal -= lastAmount;
    }
    lastAmount = totalAmount;
    // Update the total amount directly
    var newAmount = parseFloat($('#dish-org-price').val()) + parseFloat(totalAmount) + parseFloat(ingAmount);
    $('#total-amt' + dishId).text((newAmount).toFixed(2));
    // console.log("totalAmount", totalAmount, parseFloat($('#dish-org-price').val()), $('#dish-org-price').val())
    // var newAmount = $('#dish-org-price').val() + totalAmount
    // updateCartAmount(dishId, totalAmount, 'add')
}

function addCustomizedCart(id, doesExist = 0) {

    var dishData = new FormData();
    var totalDishQty = $('#totalDishQty').val()

    // old code comment 13-08-2024
    /*$("#dish-option" + id).on('change', function () {
        $('.dish-option-error').hide();
    })*/

    var isValid = true;

    // Check each dropdown
    $('.dish-option-select').each(function () {
        if ($(this).val() === null) {
            $(this).closest('.custom-default-dropdown').find('.dish-option-error').removeClass('d-none');
            isValid = false;
        } else {
            dishData.append('option[]', $(this).val())
            $(this).closest('.custom-default-dropdown').find('.dish-option-error').hide();
        }
        $(".dish-option-select").on('change', function () {
            $(this).closest('.custom-default-dropdown').find('.dish-option-error').hide();
        })

    });

if (isValid == true) {
    $(".dish-option-select").change(function () {
        $(this).closest('.custom-default-dropdown').find('.dish-option-error').hide();
    })
    if ($('.dishFreeIngQty').length) {
        $('.dishFreeIngQty:checked').each(function (index, element) {
            dishData.append('freeIng[]', $(element).data('id'))
        })
    }

    if ($('.dishPaidIngQty').length) {
        $('.dishPaidIngQty').each(function (index, element) {
            if ($(element).val() > 0) {
                dishData.append('paidIng[' + $(element).data('id') + ']', $(element).val())
            }
        })
    }

    dishData.append('dishQty', totalDishQty)
    dishData.append('doesExist', doesExist)

    $.ajax({
        url: baseURL + '/user/add-cart/' + id,
        type: 'POST',
        data: dishData,
        processData: false,
        contentType: false,
        success: function (response) {

            if (response.status == 401) {
                $('#signInModal').modal('show');
                return false;
            }

            if (response.status == 200) {
                $('#customisableModal').modal('hide');

                if ($('#qty-' + response.message.addedDishId).length > 0) {
                    var totalAmount
                    if (doesExist == 0) {
                        var currentVal = $('#qty-' + response.message.addedDishId).val()
                        totalAmount = parseInt(currentVal) + parseInt(totalDishQty)
                    } else {
                        totalAmount = parseInt(totalDishQty)
                        $('#item-ing-desc' + doesExist).html(response.message.ingListData)
                        $('#qty-' + doesExist).attr('data-ing', response.message.paidIngAmt)
                    }
                    // old code commented 13-08-2024
                    /*if (response.message.dishOption) {
                        $('#dish-option-' + response.message.addedDishId).attr('data-dish-option', response.message.dishOption.option_en)
                        $('#dish-option-' + response.message.addedDishId).text(response.message.dishOption.option_en);
                    }*/
                    if (response.message.dishOption) {
                        $('#dish-option-' + response.message.addedDishId).attr('data-dish-option', response.message.dishOption.option_en)
                        $('#dish-option-' + response.message.addedDishId).html(response.message.dishOption);
                    }
                    $('#qty-' + response.message.addedDishId).val(totalAmount)

                    //update dish qty realtime code
                    $('#quantity-' + response.message.addedDishId).html(totalAmount)
                } else {
                    /*$("#dish-cart-lbl-" + id).text('Added to cart');
                        $("#dish-cart-lbl-" + id).prop('disabled',
                    );*/
                    $('.cart-items').append(response.message.cartHtml);
                    $('#cart-item-count').text(parseInt($('#cart-item-count').text()) + 1)
                    $('#cart-count-sticky').text(parseInt($('#cart-count-sticky').text()) + 1)
                }



                $('#empty-cart-div').hide()
                $('#checkout-cart').removeClass('d-none')
                $('#cart-bill-div').removeClass('d-none')
                $('#cart-amount-cal-data').show()
                // when update ingredients then update amount in cart.
                var totalAmounts  = parseFloat(response.message.totalAmount + response.message.paidIngAmt + response.message.optionTotalAmount).toFixed(2)
                $('#cart-item-price' + response.message.addedDishId).html('+€' + totalAmounts)
                $('#dish-price-' + response.message.addedDishId).val(totalAmounts)
                // when update ingredients then update amount in cart.
                calculateTotalCartAmount()

            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);;
        }
    })
    }
}

function updateCartAmount(dishId, amount, type, dish = 0) {
    var currentVal = $('#total-amt' + dishId).text().replace(/,/g, '')
    var ingAmount = 0.00

    if (dish == 1) {
        if ($('.dishPaidIngQty').length) {
            $('.dishPaidIngQty').each(function (index, element) {
                if ($(element).val() > 0) {
                    ingAmount += parseFloat($(element).data('price')) * parseInt($(element).val())
                }
            })
        }
    }

    if (type == 'add') {
        $('#total-amt' + dishId).text((parseFloat(currentVal) + (parseFloat(amount) + parseFloat(ingAmount))).toFixed(2))
    } else if (type == 'sub') {
        $('#total-amt' + dishId).text((parseFloat(currentVal) - (parseFloat(amount) + parseFloat(ingAmount))).toFixed(2))
    }

}

function calculateTotalCartAmount() {

    var totalAmt = 0.00;
    var serviceCharge = $('#service-charge').val()
    var deliveryCharge = $('#delivery-charge').val()

    var couponDiscountPercent = $('#coupon-discount-percent').val()
    var couponDiscount = 0.00

    $('.cart-amt').each(function (index, element) {
        var id = $(element).data('id')
        var itemAmount = (parseFloat($(element).val()) * parseFloat($('#dish-price-' + id).val()))

        $('#cart-item-price' + id).text('+€' + itemAmount.toFixed(2))
        $('#paid-ing-price' + id).text('+€' + (parseFloat($(element).val()) * parseFloat($(element).attr('data-ing'))).toFixed(2))
        // old code comment on 13-08-2024
        // totalAmt += itemAmount + parseFloat(parseFloat($(element).val()) * parseFloat($(element).attr('data-ing')))
        totalAmt += itemAmount
    })

    $('#total-cart-bill').text('€' + totalAmt.toFixed(2))
    $('#total-cart-bill-amount').val(totalAmt.toFixed(2))

    couponDiscount = parseFloat(couponDiscountPercent) * totalAmt
    totalAmt += parseFloat(serviceCharge)
    if(deliveryCharge) {
        totalAmt += parseFloat(deliveryCharge)
    }
    totalAmt -= parseFloat(couponDiscount)

    $('#coupon-discount-text').text('-€' + couponDiscount.toFixed(2))
    $('#coupon-discount').val(couponDiscount.toFixed(2))

    $('#gross-total-bill').text('€' + totalAmt.toFixed(2))
    $('#gross-total-bill1').text('€' + totalAmt.toFixed(2))

    // checkout button enables disable as per client feeedback july 2024 CR points
    var min_order_price = $('.min_order_price').html()
    var currentAmount = $('.bill-count').html()
    currentAmount = currentAmount.replace('€', '')
    if ($('.TakeAway-tab .active').length == 0) {
        if (parseFloat(currentAmount) >= parseFloat(min_order_price)) {
            $('.checkout-sticky-btn').removeClass('show-hide-btn');
        } else {
            $('.checkout-sticky-btn').addClass('show-hide-btn');
        }
    } else {
        $('.checkout-sticky-btn').removeClass('show-hide-btn');
    }
}

// add note close button new code implemented
$(document).on('click', '.dish-group .form-label', function ()
{
    var formGroup = $(this).closest('.dish-group');
    var inputField = formGroup.find('input.dish-notes');

    $(this).addClass("d-none");
    inputField.removeClass("d-none");
    formGroup.find('a.note-close-btn').removeClass("d-none")
})

$(document).on('click', '.note-close-btn', function(e) {

    e.preventDefault(); // Prevent the default action of the link
    var notes = " "
    var id = $(this).data('id')
    var noteCloseBtn = $(this)

    // Find the parent .dish-group div that matches the data-dish-id
    let parentGroup = $(this).closest('.dish-group[data-dish-id="' + id + '"]');

    $.ajax({
        url: baseURL + '/user/cart/update-notes/' + id,
        type: 'PATCH',
        data: {
            notes
        },
        success: function (response) {
            if (response.status != 200) {
                // alert(response.message);
                toastr.warning(response.message);
            }
            if (response.status == 200) {
                // Find the corresponding input and label within the parent group
                let dishNotesInput = parentGroup.find('.dish-notes');
                let dishNotesLabel = parentGroup.find('.dish-notes-label');

                // Clear the input value
                dishNotesInput.val('');

                // Add the d-none class to the input and close button
                dishNotesInput.addClass('d-none');
                noteCloseBtn.addClass('d-none');

                // Remove the d-none class from the label
                dishNotesLabel.removeClass('d-none');
                dishNotesLabel.css('display', 'block');
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
})

$(".dish-notes").each(function(){
    let not_values = $(this).val();
    if(not_values !== undefined && not_values.length > 0) {
        // Hide the associated label and show the notes and close button
        $(this).closest('.dish-group').find('.dish-notes-label').hide();
        $(this).removeClass('d-none');
        $(this).closest('.dish-group').find('.note-close-btn').removeClass('d-none');
    }
});
// add note close button new code implemented


/*let not_values = $('.dish-notes').val();
console.log('not_values', not_values)
 if(not_values != undefined && not_values.length > 0) {
    $('.dish-notes-label').css('display','none');
    // $('.dish-notes').css('display','block !important');
    // $('.dish-notes').css({display:"block !important;"});
    $('.dish-notes').removeClass('d-none');
    $('.note-close-btn').removeClass('d-none');
 }*/

