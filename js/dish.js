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

    $(document).on('click', '.edit-ing-btn', function () {
        var id = $(this).attr('data-id')
        $('#dish-edit'+id)
        $(this).hide()
    })

    $(document).on('click', '.save-edit-btn', function () {
        $(this).parent().parent().siblings().children('input').attr("readonly", true);
        $(this).siblings('a.del-ing-btn').show()
        $(this).siblings('a.edit-ing-btn').show()
        $(this).parent().parent().siblings().children('img').show()
        $(this).parent().parent().siblings().children('div.imageupload-box').hide()
        $(this).attr("style", "display: none !important");
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
