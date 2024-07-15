var distance = $('.content-main-part').offset().top;
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
            $('.minimum_amount').hide()
        } else {
            $('.minimum_amount').show()
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
                    if (type == '1') {

                        // checkout button enables disable as per client feeedback july 2024 CR points
                        var min_order_price = $('.min_order_price').html()
                        var currentAmount = $('.bill-total-count').html()
                        currentAmount = currentAmount.replace('€', '')
                        if (parseFloat(currentAmount) >= parseFloat(min_order_price)) {
                            $('.checkout-sticky-btn').removeClass('show-hide-btn');
                        } else {
                            $('.checkout-sticky-btn').addClass('show-hide-btn');
                        }
                        // Hide as per client feeedback June CR points
                        // $('#addressChangeModal').modal('show')
                    } else {
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
                    // alert(response.message);
                    toastr.error(response.message);
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

function addCustomizedCart(id, doesExist = 0) {

    var dishData = new FormData();
    var totalDishQty = $('#totalDishQty').val()
    $("#dish-option" + id).on('change', function () {
        $('.dish-option-error').hide();
    })
        if ($("#dish-option" + id).length > 0 && $("#dish-option" + id).val() != null) {
            dishData.append('option', $("#dish-option" + id).val())
            $('.dish-option-error').hide();
        } else {
            if ($("#dish-option" + id).length > 0) {
                $('.dish-option-error').removeClass('d-none');
                return false;
            }
        }

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
                    $('#qty-' + response.message.addedDishId).val(totalAmount)
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
    var couponDiscountPercent = $('#coupon-discount-percent').val()
    var couponDiscount = 0.00

    $('.cart-amt').each(function (index, element) {
        var id = $(element).data('id')

        var itemAmount = (parseFloat($(element).val()) * parseFloat($('#dish-price-' + id).val()))

        $('#cart-item-price' + id).text('+€' + itemAmount.toFixed(2))
        $('#paid-ing-price' + id).text('+€' + (parseFloat($(element).val()) * parseFloat($(element).attr('data-ing'))).toFixed(2))
        totalAmt += itemAmount + parseFloat(parseFloat($(element).val()) * parseFloat($(element).attr('data-ing')))

    })

    $('#total-cart-bill').text('€' + totalAmt.toFixed(2))
    $('#total-cart-bill-amount').val(totalAmt.toFixed(2))

    couponDiscount = parseFloat(couponDiscountPercent) * totalAmt
    totalAmt += parseFloat(serviceCharge)
    totalAmt -= parseFloat(couponDiscount)

    $('#coupon-discount-text').text('-€' + couponDiscount.toFixed(2))
    $('#coupon-discount').val(couponDiscount.toFixed(2))

    $('#gross-total-bill').text('€' + totalAmt.toFixed(2))
    $('#gross-total-bill1').text('€' + totalAmt.toFixed(2))

    // checkout button enables disable as per client feeedback july 2024 CR points
    var min_order_price = $('.min_order_price').html()
    var currentAmount = $('.bill-total-count').html()
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


$(document).on('click', '.dish-group .form-label', function ()
{
    var formGroup = $(this).closest('.dish-group');
    var inputField = formGroup.find('input.dish-notes');

    $(this).addClass("d-none");
    inputField.removeClass("d-none");
})

let not_values = $('.dish-notes').val();
 if(not_values != undefined && not_values.length > 0) {
    $('.dish-notes-label').css('display','none');
    // $('.dish-notes').css('display','block !important');
    // $('.dish-notes').css({display:"block !important;"});
    $('.dish-notes').removeClass('d-none');
 }

