$(function () {
    $("#coupon-form").validate({
        submitHandler: function (form) {
            saveCoupon();
        }
    });

    /*$('#expiry_date').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        orientation: "bottom left",
        startDate: new Date()
    });*/

    $('#expiry_date').daterangepicker({
        minDate: new Date(),
        enablePastDates: true
    });

    $(document).on('click', '#coupon-delete-btn', function () {

        $('#coupon-delete-btn').prop('disabled', true);
        var id = $('#id').val();

        $.ajax({
            url: 'coupons/' + id,
            type: 'DELETE',
            success: function (response) {
                toastr.success(response.message)

                setTimeout(function(){ window.location.reload(); }, 500);
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $('.form-check-input').change(function () {

        var status = this.checked == true ? 1 : 0;
        var id = $('#id').val();

        $.ajax({
            url: 'coupons/change-status',
            type: 'POST',
            data: {
                id, status
            },
            success: function (response) {
                toastr.success(response.message)
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $('#addCouponModal').on('hidden.bs.modal', function () {
        var alertas = $('#coupon-form');
        alertas.trigger("reset");
        alertas.validate().resetForm();
        $(".modal-title").text($('#add_coupon').text())
    });

});

function saveCoupon() {
    $('#coupon-save-btn').prop('disabled', true);

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
            id, points, price, promo_code, percentage_off, description, expiry_date
        },
        success: function (response) {
            if(id > 0){
                toastr.success(response.message)
            }else{
                toastr.success(response.message)
            }

            setTimeout(function(){ window.location.reload(); }, 500);
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function deleteCoupon(id) {
    $('#id').val(id);
    $('#deleteCouponModal').modal('show');
}

function editCoupon(id) {
    $(".modal-title").text($('#edit_coupon').text())

    $.ajax({
        url: 'coupons/' + id + '/edit',
        type: 'GET',
        success: function (response) {
            var data = response.data;

            var searched_date =  moment(data.start_expiry_date).format('MM/DD/YYYY') + ' - ' + moment(data.end_expiry_date).format('MM/DD/YYYY');

            $("#addCouponModal").find("#points").val(data.points);
            $("#addCouponModal").find("#price").val(data.price);
            $("#addCouponModal").find("#promo_code").val(data.promo_code);
            $("#addCouponModal").find("#percentage_off").val(data.percentage_off);
            $("#addCouponModal").find("#expiry_date").val(searched_date);
            $("#addCouponModal").find("#description").val(data.description);
            $("#addCouponModal").find("#id").val(data.id);

            $("#addCouponModal").modal('show');
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
