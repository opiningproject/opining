$(function () {
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

    $('#addressChangeModal').on('hidden.bs.modal', function () {
        var alertas = $('#address-form');
        alertas.trigger("reset");
        alertas.validate().resetForm();

        $("#zipcode-error").addClass('d-none');
    });

    $(document).on('click', '.select-address-btn', function () {

        var parentId = $(this).closest('div[id^="address-"]').attr('id');

        // Extract the address ID from the parent div's ID
        var addressId = parentId.split('-')[1];

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
                if (response.status == 406) {

                    $('#zipcode-error').text(response.data.message);
                    $('#zipcode-error').css("display", "block");
                } else {

                    $('#selected-address-'+addressId).html('<span class="success-ico"><img src="/images/success-icon.svg" class="svg" width="14" height="11"></span>');

                    let houseNumber = response.data.house_no;
                    let zipcode = response.data.zipcode;
                    let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                    $("#zip_address").html('');
                    $("#zip_address").html('<p class="mb-0">' + displayText + '</p>');

                    $('#addressChangeModal').modal('hide');

                    $('#addressChangeModal').on('hidden.bs.modal', function () {
                        $('#zipcode').val(response.data.zipcode)
                    $('#house_no').val(response.data.house_no)
                    });

                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

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
                    let displayText = houseNumber ? houseNumber + ', ' + zipcode : '';
                    $("#zip_address").html('');
                    $("#zip_address").html('<p class="mb-0">' + displayText + '</p>');
                    $('#addressChangeModal').modal('hide');
    
                    // After closing modal set updated values
                    $('#addressChangeModal').on('hidden.bs.modal', function () {
                        $('#house_no').val(response.house_number)
                        $('#zipcode').val(response.zipcode)
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
            console.log('success')
            console.log(response)
            $('#address-' + id).remove();
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
