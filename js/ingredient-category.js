$(function () {

    $("#ingCategoryForm").validate({
        rules: {
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            }
        },
        submitHandler: function (form) {
            form.submit()
        }
    });

    $(document).on('click', '#delete-category-btn', function () {

        var id = $('#catId').val();

        $.ajax({
            url: baseURL + '/menu/ingredients/category/' + id,
            type: 'DELETE',
            success: function (response) {
                window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('click','.del-cat-icon', function () {
        var id = $(this).attr('data-id')
        $('#catId').val(id)
    })


    $(document).on('click', '.edit-cat-icon', function () {
        var id = $(this).attr('data-id')
        $(this).parent().parent().siblings().children('input').attr("readonly", false).focus();
        $('#save-edit-btn'+id).show()
        $('#edit-btn'+id).hide()
        $('#del-btn'+id).hide()
    })

    $(document).on('click', '.save-edit-btn', function () {
        var id = $(this).attr('data-id')

        var name_en = $('#name_en'+id).val()
        var name_nl = $('#name_nl'+id).val()

        $.ajax({
            url: baseURL + '/menu/ingredients/category/'+id,
            type: 'PUT',
            data: {
                name_en,
                name_nl
            },
            success: function (response) {
                window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })
});
