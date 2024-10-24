$(function () {
    $("#categoryForm").validate({
        ignore: [],
        rules: {
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            },
            image: {
                required: true,
            }
        },
        submitHandler: function (form) {
            saveCategory('add');
        }
    });

    $("#editCategoryForm").validate({
        rules: {
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            }
        },
        submitHandler: function (form) {
            saveCategory('edit');
        }
    });

    $(document).on('click', '#delete-category-btn', function () {

        $('#coupon-delete-btn').prop('disabled', true);
        var id = $('#catId').val();

        $.ajax({
            url: 'category/' + id,
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

    $(document).on('click', '.del-cat-icon', function () {
        var id = $(this).attr('data-id')
        $('#catId').val(id)

        $.ajax({
            url: 'category/checkDishes/' + id,
            type: 'GET',
            success: function (response) {
                if (response.status == 200) {
                    $('#catId').val(id)
                    $('#deleteCategoryAlertModal').modal('show')
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

    $(document).on('click', '.category-edit-btn', function () {

        var id = $(this).attr('data-id');
        $('#editCatId').val(id)

        $.ajax({
            url: 'category/' + id,
            type: 'GET',
            success: function (response) {
                var data = response.data;
                $("#edit_name_en").val(data.name_en);
                $("#edit_name_nl").val(data.name_nl);
                $("#edit-img-preview").attr('src',data.image);
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $('#addCategoryModal').on('hidden.bs.modal', function () {
        var alertas = $('#categoryForm');
        alertas.validate().resetForm();
        alertas.trigger("reset");
        alertas.find('.error').removeClass('error');
        $('#img-label').show()
        $('#img-preview').attr('src', 'images/blank-img.svg').attr('style','height:auto !important');
    });

    $('#editCategoryModel').on('hidden.bs.modal', function () {
        var alertas = $('#editCategoryForm');
        alertas.trigger("reset");
        alertas.validate().resetForm();
    });

    $(document).on('change', '#input-file', function () {

        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) {
            alert($('#image_type_error').text());
            return false
        }

        var imgWidth = $(this).width();
        var imgHeight =$(this).height();
        if(imgWidth > 1080 || imgHeight > 1080){
            alert($('#image_size_error').text());
            return false
        }

        $('#img-preview').attr('style','height:100px !important')
        addCategoryReadURL(this);
        $('#img-label').hide()
    });

    $(document).on('change', '#edit-input-file', function () {

        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg','svg']) == -1) {
            alert($('#image_type_error').text());
            return false
        }

        var imgWidth = $(this).width();
        var imgHeight =$(this).height();
        if(imgWidth > 1080 || imgHeight > 1080){
            alert($('#image_size_error').text());
            return false
        }

        editCategoryReadURL(this);
        $('#edit-img-preview').attr('style','height:100px !important')
    });

    function addCategoryReadURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function editCategoryReadURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#edit-img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
});

function saveCategory(type) {
    var catData = ''
    if (type == 'add'){
        catData = new FormData(document.getElementById('categoryForm'));
    }else{
        catData = new FormData(document.getElementById('editCategoryForm'));
    }

    $.ajax({
        url: baseURL + '/category',
        type: 'POST',
        processData: false,
        contentType: false,
        data: catData,
        success: function (response)
        {
            toastr.success(response.message)
            setTimeout(function(){ window.location.reload(); }, 500);

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
