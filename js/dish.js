$(function () {
    $(document).on('click', '.del-ing-btn', function () {

        var id = $(this).attr('data-id');

        $.ajax({
            url: baseURL + '/menu/ingredients/' + id,
            type: 'GET',
            success: function (response) {
                console.log(response)
                // window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('click', '.free-ingredient-edit-btn', function () {
        var id = $(this).attr('data-id')
        $('#free-ingredient-delete'+id).hide()
        $('#free-ingredient-save'+id).show()
        $('#')
        $(this).hide()
    })

    $(document).on('change', '.ingred-category', function () {
        var catId =  $(this).val()

        $.ajax({
            url: baseURL + '/menu/ingredients/category/' + catId,
            type: 'POST',
            data: {
            },
            success: function (response) {
                console.log(response)
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })
});
