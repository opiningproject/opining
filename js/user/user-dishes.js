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
            console.log('success')
            console.log(response)
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function customizeDish(id) 
{
    $.ajax({
            url: baseURL+'/user/get-dish-details/'+id,
            type: 'GET',
            success: function (response) {
                
                var data = response.data;

                if(response.status == 2)
                {
                   $('#signInModal').modal('show');
                   return false;
                }

                $('.modal-dialog').html(data);

                $("#customisableModal").modal("show"); 

            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    
}