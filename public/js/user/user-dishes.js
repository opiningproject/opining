function unFavorite(dish_id)
{
    $('#dish-box-'+dish_id).hide();

    $.ajax({
        url: baseURL+'/unFavorite',
        type: 'POST',
        data: {
            dish_id
        },
        success: function (response) {

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function customizeDish(id, doesExist=0)
{
    $.ajax({
        url: baseURL+'/user/get-dish-details/'+id+'/'+doesExist,
        type: 'GET',
        success: function (response) {

            var data = response.data;

            if(response.status == 2)
            {
                $('#signInModal').modal('show');
                return false;
            }

            $('.customisable-modal-body').html(data);

            $("#customisableModal").modal("show");

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })


}
