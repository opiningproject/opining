$(document).on('click', '#delete-dish-btn', function (){
    var id = $('#dishId').val()

    $.ajax({
        url: baseURL + '/menu/dish/' + id,
        type: 'DELETE',
        success: function (response) {
            $('#deleteDishAlertModal').modal('hide')
            if (response.status == 200) {
                $('#dish-card-div'+id).remove()
            } else {
                alert(response.message);
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
})

$(document).on('click', '.del-dish-btn', function (){
    var id = $(this).attr('data-id')
    $('#dishId').val(id)
})
