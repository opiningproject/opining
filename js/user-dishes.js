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