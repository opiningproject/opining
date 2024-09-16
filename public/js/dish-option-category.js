$(function () {

    $("#dishOptionCategoryForm").validate({
        rules: {
            title_en: {
                required: true
            },
            title_nl: {
                required: true
            },
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            }
        },
        submitHandler: function (form) {
            saveIngredientCategory()
        }
    });

    $("#ingredientCategoryTbody").sortable({
        update: function() {
            updateRowOrder();
        }
    });

    function updateRowOrder(){

        var order = [];
        $('tr.ingredientCategoryRow').each(function(index,element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index+1
            });
        });

        $.ajax({
            type: "POST",
            url: "category/updateCategoryRowOrder",
            cursor: 'move',
            data: {
                order,
            },
            success: function(response) {

            }
        });
    }

    $(document).on('click', '#delete-category-btn', function () {

        var id = $('#catId').val();

        $.ajax({
            url: baseURL + '/menu/dish-options/category/' + id,
            type: 'DELETE',
            success: function (response) {
                $('#ing-tr'+id).remove();
                $('#deleteAlertModal').modal('hide')
                toastr.success(response.message)

            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $(document).on('click', '.del-cat-icon', function () {
        var id = $(this).attr('data-id')
        $('#catId').val(id)
    })

    $(document).on('change', '#per_page_dropdown', function () {
        var url = this.value;
        window.open(url, '_parent');
    })

    $(document).on('click', '.edit-cat-icon', function () {
        var id = $(this).attr('data-id')
        $(this).parent().parent().siblings().children('input').attr("readonly", false).focus();
        $('#save-edit-btn' + id).show()
        $('#edit-btn' + id).hide()
        $('#del-btn' + id).hide()
    })

    $(document).on('click', '.del-cat-icon', function () {

        var id = $(this).attr('data-id');
        $('#catId').val(id)
        $('#deleteAlertModal').modal('show')
        // $.ajax({
        //     url: baseURL + '/menu/dish-options/category/checkItems/' + id,
        //     type: 'GET',
        //     success: function (response) {
        //         if (response.status == 200) {
        //             $('#catId').val(id)
        //             $('#deleteAlertModal').modal('show')
        //         } else {
        //             $('#deleteAlertModalMsg').modal('show')
        //         }
        //     },
        //     error: function (response) {
        //         var errorMessage = JSON.parse(response.responseText).message
        //         toastr.error(errorMessage)
        //         // alert(errorMessage);
        //     }
        // })
    })

    $(document).on('click', '.save-edit-btn', function () {
        console.log("in")
        var id = $(this).attr('data-id')

        var name_en = $('#name_en' + id).val()
        var name_nl = $('#name_nl' + id).val()
        var title_en = $('#title_en' + id).val()
        var title_nl = $('#title_nl' + id).val()

        if(name_en == ''){
            $('#name_en' + id).focus();
            return false
        }

        if(name_nl == ''){
            $('#name_nl' + id).focus();
            return false
        }
        if(title_en == ''){
            $('#title_en' + id).focus();
            return false
        }
        if(title_nl == ''){
            $('#title_nl' + id).focus();
            return false
        }

        $.ajax({
            url: baseURL + '/menu/dish-options/category/' + id,
            type: 'PUT',
            data: {
                name_en,
                name_nl,
                title_en,
                title_nl
            },
            success: function (response) {
                console.log(response.data)
                if (response.status == 200) {
                    $('#name_en'+id).prop('readonly', true)
                    $('#name_nl'+id).prop('readonly', true)
                    $('#title_en'+id).prop('readonly', true)
                    $('#title_nl'+id).prop('readonly', true)
                    $('#edit-btn'+id).show()
                    $('#del-btn'+id).show()
                    $('#save-edit-btn'+id).attr('style','width: 50%;margin-left: 25%; display: none!important; !important')
                    toastr.success(response.message)
                } else {
                    toastr.error(response.message)
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })

    })
});

function saveIngredientCategory() {
    var dishOptionData = new FormData(document.getElementById('dishOptionCategoryForm'));

    $.ajax({
        url: baseURL + '/menu/dish-options/category',
        type: 'POST',
        processData: false,
        contentType: false,
        data: dishOptionData,
        success: function (response) {
            if (response.status == 200) {
                var id = response.data.id

                var html = '<tr id="ing-tr'+ id +'">' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               data-id="' + id + '"' +
                    '                               value="' + response.data.name_en + '"' +
                    '                               id="name_en' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               value="' + response.data.name_nl + '"' +
                    '                               id="name_nl' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               value="' + response.data.title_en + '"' +
                    '                               id="title_en' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto"' +
                    '                               value="' + response.data.title_nl + '"' +
                    '                               id="title_nl' + id + '"' +
                    '                               readonly/>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '    <div class="">' +
                    '        <a class="btn btn-site-theme btn-icon edit-cat-icon"' +
                    '           id="edit-btn' + id + '"' +
                    '           data-id="' + id + '" tabindex="0">' +
                    '            <i class="fa-solid fa-pen-to-square"></i>' +
                    '        </a>' +
                    '        <a class="btn btn-site-theme btn-icon del-cat-icon"' +
                    '           id="del-btn' + id + '"' +
                    '           data-bs-toggle="modal" data-id="' + id + '"' +
                    '           data-bs-target="#deleteAlertModal">' +
                    '            <i class="fa-regular fa-trash-can"></i>' +
                    '        </a>' +
                    '        <a class="btn btn-site-theme btn-default save-edit-btn d-block"' +
                    '           id="save-edit-btn' + id + '"' +
                    '           style="width: auto;margin-left: 0%; display: none!important;"' +
                    '           data-id="' + id + '">' +
                    '            <span class="align-middle">'+ dishValidation.save_btn +'</span>' +
                    '        </a>' +
                    '    </div>' +
                    '</td>' +
                    '</tr>';
                $('#ingredientCategoryTbody').prepend(html)
                $('#dishOptionCategoryForm').trigger('reset')

                toastr.success(response.message)

            }else{
                toastr.error(response.message)
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
}
