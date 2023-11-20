$(function () 
{
    $("#coupon-form").validate({
          //debug:true,
          submitHandler: function(form) {
            saveCoupon();
          }
     });

    $('#expiry_date').datepicker({
        format: 'mm-dd-yyyy',
        autoclose: true,
        orientation: "bottom left",
        startDate: new Date()
    });

    $(document).on('click', '#coupon-delete-btn', function () {

        $('#coupon-delete-btn').prop('disabled',true);
        var id = $('#id').val();

        $.ajax({
            url: 'coupons/'+id,
            type: 'DELETE',
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
            url: 'coupons/change-status',
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

    $(document).on('click', '#coupon-edit-btn', function () {

        var id = $('#id').val();

        $(".modal-title").text("Edit Coupon")

        $.ajax({
            url: 'coupons/'+id+'/edit',
            type: 'GET',
            success: function (response) {
                var data = response.data;

                $("#addCouponModal").find("#points").val(data.points);
                $("#addCouponModal").find("#price").val(data.price);
                $("#addCouponModal").find("#promo_code").val(data.promo_code);
                $("#addCouponModal").find("#percentage_off").val(data.percentage_off);
                $("#addCouponModal").find("#expiry_date").val(data.expiry_date);
                $("#addCouponModal").find("#description").val(data.description);
                $("#addCouponModal").find("#id").val(data.id);

                $("#addCouponModal").modal('show');
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $('#addCouponModal').on('hidden.bs.modal', function () {
      let validator = $("#Form").validate();
      //validator.resetForm();  
      $('#Form').trigger('reset');
      $(".modal-title").text("Add Coupon")
      $("#addCouponModal").find('.error').removeClass("error");
    });

});

function saveCoupon() 
{
    $('#coupon-save-btn').prop('disabled',true);

    var points = $('#points').val();
    var price = $('#price').val();
    var promo_code = $('#promo_code').val();
    var percentage_off = $('#percentage_off').val();
    var description = $('#description').val();
    var expiry_date = $('#expiry_date').val();
    var id = $('#addCouponModal #id').val();

    $.ajax({
        url: 'coupons',
        type: 'POST',
        data: {
            id,points,price,promo_code,percentage_off,description,expiry_date
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