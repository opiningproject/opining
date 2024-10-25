$(function () {
    $('.add-customer').on("click", function () {
        $('.create-customer-popup').modal('show')
    });

    $(function () {
        $("#create-user-form").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true
                },
                phone: {
                    required: true
                },
                street: {
                    required: true
                },
                house_number: {
                    required: true
                },
                postal_code: {
                    required: true
                },
                city: {
                    required: true
                }
            },
            submitHandler: function (form) {
                saveCustomer()
            }
        });
    })

    function saveCustomer() {
        var customerData = new FormData(document.getElementById('create-user-form'));

        $.ajax({
            url: baseURL + '/create-customer',
            type: 'POST',
            processData: false,
            contentType: false,
            data: customerData,
            success: function (response) {
                console.log(response)
                if (response.status == 200) {
                    toastr.success(response.message)
                    setTimeout(function(){ window.location.reload(); }, 500);
                    $('#createCustomerModal').modal('hide');
                    $('#create-user-form')[0].reset();
                }else{
                    toastr.error(response.message)
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
            }
        })
    }


    $('.modal-footer .close').on('click', function() {
        $('#createCustomerModal').modal('hide');
        $('#create-user-form')[0].reset();
    });

    // Close modal when the close icon (top right) is clicked
    $('.modal-header .close').on('click', function() {
        $('#createCustomerModal').modal('hide');
        $('#create-user-form')[0].reset();
    });



})
function getDishes(catId) {
    $('.tab-listing .category').removeClass('active');  // Remove active class from all
    $('.category-' + catId + ' .category').addClass('active');
    if(!catId) {
        catId = $('#view-all-dishes').attr('data-category-id');
    }
    activateSlide(catId);

    $.ajax({
        url: `${baseURL}/get-dish/${catId}`,
        type: 'GET',
        success: function (response) {
            // update view all button attribute id
            $('#view-all-dishes').attr('data-category-id',catId);

            $('.sub-title').text(response.cat_name)
            $('.order-listing-row').html(response.data)
        },
        error: function (response) {}
    })
}

function activateSlide(categoryId) {

    // Find the index of the slide with the given category ID
    var slideIndex = $('.swiper-slide[data-category-id="' + categoryId + '"]').index();
    // Check if the slide index is valid
    if (slideIndex >= 0) {
        // Use Swiper's slideTo method to make the specific slide active
        swiper.slideTo(slideIndex);

        // Remove active class from all slides
        $('.swiper-slide').removeClass('selected-cart-active swiper-slide-active');

        // Add active class to the selected slide
        $('.swiper-slide[data-category-id="' + categoryId + '"]').addClass('selected-cart-active swiper-slide-active');
    }
}

//customizeDish
function customizeDish(id, doesExist=0)
{
    console.log("in")
    $.ajax({
        url: baseURL+'/get-dish-details/'+id+'/'+doesExist,
        type: 'GET',
        success: function (response) {

            var data = response.data;

            if(response.status == 2)
            {
                $('#signInModal').modal('show');
                return false;
            }

            $('.customisable-modal-body').html(data);

            $("#customisableModal").modal("show");

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
// add Sub Dish Ingredient
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


function addCustomizedCartCustom(id, doesExist = 0) {

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
            url: baseURL + '/custom-add-cart/' + id,
            type: 'POST',
            data: dishData,
            processData: false,
            contentType: false,
            success: function (response) {

                // if (response.status == 401) {
                //     $('#signInModal').modal('show');
                //     return false;
                // }

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
                        $('.order-dt-row').append(response.message.cartHtml);
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
    console.log("currentAmount",currentAmount)
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
// Ensure the DOM is fully loaded before attaching the event
$('#house_number, #postal_code').on('blur', function() {
    // Get values from both inputs
    var houseNumber = $('#house_number').val();
    var postalCode = $('#postal_code').val();

    // Call your function and pass the values
    handleInputValues(postalCode, houseNumber);
});

// Function to handle the values from both inputs
function handleInputValues(zipcode, house_no) {
    console.log('House Number:', house_no);
    console.log('Postal Code:', zipcode);
    // var zipcode = $('#zipcode').val();
    // var house_no = $('#house_no').val();

    // Add your logic here
    // Example: You can check if both values are filled
    if (zipcode === '' || house_no === '') {
        // alert('Both fields are required');
    } else {


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
                    if(response.zipcode && response.house_number) {

                        let houseNumber = response.house_number;
                        let zipcode = response.zipcode;
                        let city = response.city;
                        let street_name = response.street_name;
                        let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                        $('#street').val(street_name);
                        $('#city').val(city);

                    }
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
        // Call any other function or logic you need
        console.log('Both values are filled, proceed...');
    }
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
        url: baseURL + '/custom-update-dish-qty',
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
