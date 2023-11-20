$(function () 
{
    $("#zipcode-form").validate({
          //debug:true,
          submitHandler: function(form) {
            saveZipcode();
          }
    });

    $(document).on('click', '#zipcode-delete-btn', function () {

        $('#zipcode-delete-btn').prop('disabled',true);

        var id = $('#id').val();

        $.ajax({
            url: 'settings/delete-zipcode?id='+id,
            type: 'GET',
            success: function (response) {
                console.log('success')
                console.log(response)
                window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $('.form-check-input').change(function() {

        var status = this.checked == true ? 1:0;
        var id = $('#id').val();

        $.ajax({
            url: 'settings/change-status',
            type: 'POST',
            data: {
                id,status
            },
            success: function (response) {
                console.log('success')
                console.log(response)
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('click', '#zipcode-edit-btn', function () {
        var id = $(this).data('id');
        $(this).closest('tr').find('input').removeAttr('readonly');
        $('#id').val(id);

        $("#zipcode-remove-btn").hide();
        $("#zipcode-edit-btn").hide();

        $("#zipcode-save-btns").css("display", "block");
    })

    $('#addCouponModal').on('hidden.bs.modal', function () {
      let validator = $("#Form").validate();
      //validator.resetForm();  
      $('#Form').trigger('reset');
      $(".modal-title").text("Add Coupon")
      $("#addCouponModal").find('.error').removeClass("error");
    });

});

function saveZipcode() 
{
    $('#zipcode-save-btn').prop('disabled',true);

    var zipcode = $('#zipcode').val();
    var min_order_price = $('#min_order_price').val();
    var delivery_charge = $('#delivery_charge').val();
    var id = $('#id').val();
    var status = $('#status').is(':checked') == true ? '1':'0';

    $.ajax({
        url: 'settings/save-zipcode',
        type: 'POST',
        data: {
            id,zipcode,min_order_price,delivery_charge,status
        },
        success: function (response) {
            console.log('success')
            console.log(response)
            window.location.reload();
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}