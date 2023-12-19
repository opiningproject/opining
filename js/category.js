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
                required: true
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

    $(document).on('click', '.del-cat-icon', function () {
        var id = $(this).attr('data-id')
        $('#catId').val(id)
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
        $('#categoryForm').trigger('reset');
        $("#addCategoryModal").find('.error').removeClass("error");
        $('#img-label').show()
        $('#img-preview').attr('src', 'images/blank-img.svg');
    });

    $(document).on('change', '#input-file', function () {
        readURL(this);
        $('#img-label').hide()
    });

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
        success: function (response) {
            location.reload()
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}
