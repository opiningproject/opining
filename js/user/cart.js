$(function () {

    $('.pills-delivery-tab').click(function () {

        var type = $(this).data('type')
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
                        $('#addressChangeModal').modal('show')
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function (response) {

                if (response.status == 401) {
                    $('#signInModal').modal('show');
                } else {
                    var errorMessage = JSON.parse(response.responseText).message
                    alert(errorMessage);
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

                if (response.status == 400) {
                    $('#addressChangeModal').modal('show')
                } else if (response.status == 200) {
                    window.location.replace(baseURL + '/user/checkout')
                } else {
                    alert(response.message)
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $('.remove-cart-dish').click(function (){
        var id = $(this).data('id')
        var dishId = $(this).data('dish-id')

        $.ajax({
            url: baseURL + '/user/cart/remove-dish/'+ id,
            type: 'DELETE',
            success: function (response) {
                if(response.status == 200){
                    $('#cart-'+dishId).remove()
                    calculateTotalCartAmount()
                }else{
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage)
            }
        })
    })

    $('.dish-notes').focusout(function (){
        var notes = $(this).val()
        var id = $(this).data('id')

        $.ajax({
            url: baseURL + '/user/cart/update-notes/'+ id,
            type: 'PATCH',
            data: {
                notes
            },
            success: function (response) {
                if(response.status != 200){
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage)
            }
        })
    })

    $('#delivery_instruction').focusout(function (){
        var delivery_notes = $(this).val()

        $.ajax({
            url: baseURL + '/user/cart/update-del-ins/',
            type: 'PATCH',
            data: {
                delivery_notes
            },
            success: function (response) {
                if(response.status != 200){
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage)
            }
        })
    })
});

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
            $('#qty-'+id).attr('data-ing',0)
            calculateTotalCartAmount()
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function updateDishQty(operator, maxQty, dish_id) {
    var current_qty = parseInt($('input[name=qty-' + dish_id + ']').val());

    if (operator == '-' && !isNaN(current_qty) && current_qty > 0) {
        $('input[name=qty-' + dish_id + ']').val(current_qty - 1);
    }

    if (operator == '+' && !isNaN(current_qty)) {
        if (current_qty >= maxQty) {
            return false;
        }

        $('input[name=qty-' + dish_id + ']').val(current_qty + 1);
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
                $("#dish-cart-lbl-" + dish_id).text('Add +');
                $("#dish-cart-lbl-" + dish_id).prop('disabled', false);

                if ($('.cart-amt').length > 0) {
                    $('#empty-cart-div').hide()
                } else {
                    $('#empty-cart-div').show()
                    $('#cart-amount-cal-data').hide()
                }

                if(response.message){
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

            calculateTotalCartAmount()
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function applyCoupon() {
    var couponCode = $('#coupon_code').val();
    var orderAmount = $('#total-cart-bill-amount').val();

    if (couponCode == '') {
        return false;
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
            alert(errorMessage);
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
            alert(errorMessage);
        }
    })
}

function addSubDishQuantities(dishId, operator, maxQty) {

    var dishAmt = $('#dish-org-price').val()
    var currentQty = parseInt($('input[name=qty-' + dishId + ']').val());

    if (operator == '-') {
        if (currentQty != 1) {
            $('input[name=qty-' + dishId + ']').val(currentQty - 1);
        }
        updateCartAmount(dishId, dishAmt, 'sub')
    }

    if (operator == '+') {
        if (currentQty >= maxQty) {
            return false;
        }

        $('input[name=qty-' + dishId + ']').val(currentQty + 1);
        updateCartAmount(dishId, dishAmt, 'add')
    }
}

function addSubDishIngredientQuantities(IngDishId, operator, dishId) {

    var currentQty = parseInt($('#dishIng' + IngDishId).val());
    var amount = parseFloat($('#ing-price-val' + IngDishId).text())

    if (operator == '-') {
        if (currentQty != 0) {
            $('#dishIng' + IngDishId).val(currentQty - 1);
            updateCartAmount(dishId, amount, 'sub')
        }
    }

    if (operator == '+') {
        $('#dishIng' + IngDishId).val(currentQty + 1);
        updateCartAmount(dishId, amount, 'add')
    }
}

function addCustomizedCart(id) {

    var dishData = new FormData();

    if ($("#dish-option" + id).length) {
        dishData.append('option', $("#dish-option" + id).val())
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

    dishData.append('dishQty', $('#totalDishQty').val())

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

                if ($('#qty-' + id).length > 0) {
                    $('#qty-' + id).val($('#totalDishQty').val())
                } else {
                    $("#dish-cart-lbl-" + id).text('Added to cart');
                    $("#dish-cart-lbl-" + id).prop('disabled', true);
                    $('.cart-items').append(response.message.cartHtml);
                }
                $('#empty-cart-div').hide()
                $('#qty-'+id).attr('data-ing',response.message.paidIngAmt)
                $('#cart-amount-cal-data').show()
                calculateTotalCartAmount()
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function updateCartAmount(dishId, amount, type) {
    var currentVal = $('#total-amt' + dishId).text()

    if (type == 'add') {
        $('#total-amt' + dishId).text(parseFloat(currentVal) + parseFloat(amount))
    } else if (type == 'sub') {
        $('#total-amt' + dishId).text(parseFloat(currentVal) - parseFloat(amount))
    }

}

function calculateTotalCartAmount() {
    var totalAmt = 0;
    var serviceCharge = $('#service-charge').val()
    var couponDiscountPercent = $('#coupon-discount-percent').val()
    var couponDiscount

    $('.cart-amt').each(function (index, element) {
        var id = $(element).data('id')

        totalAmt += (parseFloat($(element).val()) * parseFloat($('#dish-price-' + id).val())) + parseFloat($(element).data('ing'))
    })

    $('#total-cart-bill').text('€' + totalAmt)
    $('#total-cart-bill-amount').val(totalAmt)

    couponDiscount = parseFloat(couponDiscountPercent) * totalAmt
    totalAmt += parseFloat(serviceCharge)
    totalAmt -= parseFloat(couponDiscount)

    $('#coupon-discount-text').text('-€' + couponDiscount)
    $('#coupon-discount').val(couponDiscount)

    $('#gross-total-bill').text('€' + totalAmt)
}

