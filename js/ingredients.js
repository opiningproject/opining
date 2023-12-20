$(function () {

    $("#addIngredientForm").validate({
        rules: {
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            },
            category_id: {
                required: true
            }
        },
        submitHandler: function (form) {
            form.submit()
        }
    });

    $(document).on('click', '.del-ing-btn', function () {

        var id = $(this).attr('data-id');

        $.ajax({
            url: baseURL + '/menu/ingredients/checkAttachedDish/' + id,
            type: 'GET',
            success: function (response) {
                if (response.status == 200) {
                    $('#ingredientId').val(id)
                    $('#deleteAlertModal').modal('show')
                } else {
                    $('#deleteAlertModalMsg').modal('show')
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('click', '#delete-ingredient-btn', function () {
        var id = $('#ingredientId').val()

        $.ajax({
            url: 'ingredients/' + id,
            type: 'DELETE',
            success: function (response) {
                if(response.status == 200){
                    $('#ingredient-tr'+id).remove()
                }else{
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })

    $(document).on('click', '.edit-ing-btn', function () {
        var id = $(this).attr('data-id');
        $('#catId' + id).prop('disabled', false)
        $('#dish-list'+id).prop('disabled', false)
        $(this).siblings('a.save-edit-btn').show()
        $(this).parent().parent().siblings().children('input').attr("readonly", false).focus();
        $(this).siblings('a.del-ing-btn').hide()
        $(this).parent().parent().siblings().children('img').hide()
        $(this).parent().parent().siblings().children('div.imageupload-box').show()
        $(this).hide()
    })

    $(document).on('click', '.save-edit-btn', function () {
        var id = $(this).attr('data-id');

        var category_id = $('#catId' + id).val()
        var name_en = $('#name_en' + id).val()
        var name_nl = $('#name_nl' + id).val()
        var dishes =

        $.ajax({
            url: baseURL + '/menu/ingredients/' + id,
            type: 'PUT',
            data: {
                category_id,
                name_en,
                name_nl
            },
            success: function (response) {
                if (response.status == 200) {
                    $('#catId' + id).prop('disabled', true)
                    $('#dish-list'+id).prop('disabled', true)
                    $('#name_en' + id).prop("readonly", true);
                    $('#name_nl' + id).prop("readonly", true);
                    $('#del-btn' + id).show()
                    $('#edit-btn' + id).show()
                    $('#img-div'+id).hide()
                    $('#ing-exist-img'+id).show()
                    $('#save-btn'+id).attr('style', 'display:none !important')
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })

    $(document).on('click', '.update-ing-status', function () {

        var id = $(this).val()
        var status = 0;

        if ($(this).prop('checked')) {
            status = 1;
        }

        $.ajax({
            url: baseURL + '/menu/ingredients/update-status/' + id,
            type: 'POST',
            data: {
                status
            },
            success: function (response) {
                // window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('change', '#input-file', function () {
        $('#img-preview').attr('style','height:50px !important')
        readURL(this);
        $('#img-label').hide()
    });

    $(document).on('change', '.dish-dropdown', function (){
        var ingredientId = $(this).attr('data-id')
        var dishName = $(this).find(':selected').attr('data-name')

        var html = '<span class="badge text-bg-yellow">' + dishName +'<a ' +
            'href="javascript:void(0);"><i class="fa-solid fa-xmark align-middle del-dish-icon new-added-dish" data-id="' + ingredientId +'" data-name="' + dishName + '"></i></a></span>';
        $('.dish-tray'+ingredientId).append(html)
        $(this).find(':selected').remove()
        $(this).val('')
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
});
