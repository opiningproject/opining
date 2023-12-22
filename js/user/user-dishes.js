function unFavorite(id) 
{
    $('#dish-box-'+id).hide();

    $.ajax({
        url: baseURL+'/unFavorite',
        type: 'POST',
        data: {
            id
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

                $('.modal-dialog').html(data);

                $("#customisableModal").modal("show"); 

            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    
}