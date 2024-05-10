var deletedOption = []
$(function () {

    $("#addDishForm").validate({
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
            },
            category_id: {
                required: true
            },
            qty: {
                required: true
            },
            desc_en: {
                required: true
            },
            desc_nl: {
                required: true
            },
            price: {
                required: true
            }
        },
        submitHandler: function (form) {
            form.submit()
        }
    });

    $("#editDishForm").validate({
        rules: {
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            },
            category_id: {
                required: true
            },
            qty: {
                required: true
            },
            desc_en: {
                required: true
            },
            desc_nl: {
                required: true
            },
            price: {
                required: true
            }
        },
        submitHandler: function (form) {
            updateDishData()
        }
    });

    $("#freeIngredientForm").validate({
        rules: {
            freeIngredientCategory: {
                required: true
            },
            ingredient_id: {
                required: true
            }
        },
        submitHandler: function (form) {
            addIngredient('free');
        }
    });

    $("#paidIngredientForm").validate({
        rules: {
            paidIngredientCategory: {
                required: true
            },
            ingredient_id: {
                required: true
            },
            price: {
                required: true
            }
        },
        submitHandler: function (form) {
            addIngredient('paid');
        }
    });


    $(document).on('click', '.del-ing-btn', function () {
        var id = $(this).attr('data-id');

        $.ajax({
            url: baseURL + '/menu/ingredients/' + id,
            type: 'GET',
            success: function (response) {
                // console.log(response)
                // window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $(document).on('click', '.paid-ingredient-edit-btn', function () {
        var id = $(this).attr('data-id')
        $('#paid-ingredient-delete' + id).hide()
        $('#paid-ingredient-save' + id).show()
        $('#price' + id).prop('readonly', false)
        $('#paid-price' + id).prop('readonly', true)
        $(this).hide()
    })

    $(document).on('click', '.paid-ingredient-save-btn', function () {
        var id = $(this).attr('data-id')
        var price = $('#price' + id).val()

        $.ajax({
            url: baseURL + '/menu/dish/updateIngredient/' + id,
            type: 'PATCH',
            data: {
                price
            },
            success: function (response) {
                if (response.status == 200) {
                    $('#price' + id).prop('readonly', true)
                    $('#paid-ingredient-delete' + id).show()
                    $('#paid-ingredient-edit' + id).show()
                    $('#paid-price' + id).prop('readonly', false)
                    $('#paid-ingredient-save' + id).attr('style', 'display:none !important')
                } else {
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $(document).on('change', '#freeIngredientCategory', function () {
        var catId = $(this).val()
        if (catId != '') {
            getIngredientsList(catId, 'free')
        } else {
            $('#freeIngredient').html('<option value="">'+ dishValidation.select_ingred +'</option>')
        }
    })

    $(document).on('change', '#paidIngredientCategory', function () {
        var catId = $(this).val()
        if (catId != '') {
            getIngredientsList(catId, 'paid')
        } else {
            $('#paidIngredient').html('<option value="">'+ dishValidation.select_ingred +'</option>')
        }
    })

    $(document).on('click', '.del-dish-ingredient', function () {
        $('#ingredientId').val($(this).attr('data-id'))
    })

    $(document).on('click', '#delete-dish-ingredient-btn', function () {
        var id = $('#ingredientId').val()

        $.ajax({
            url: baseURL + '/menu/dish/deleteIngredient/' + id,
            type: 'DELETE',
            success: function (response) {
                $('#deleteAlertModal').modal('hide')
                if (response.status == 200) {
                    $('#dishIngredient' + id).remove()
                    toastr.success(response.message)
                } else {
                    alert(response.message);
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                toastr.error(errorMessage)
                // alert(errorMessage);
            }
        })
    })

    $(document).on('change', '#per_page_dropdown', function () {
        var url = this.value;
        window.open(url, '_parent');
    })

    $(document).on('click', '#addOptionBtn', function (){

        var name_en = $('#option_name_en').val()
        var name_nl = $('#option_name_nl').val()

        if(name_en == '' || name_nl == ''){
            alert(dishValidation.select_option)
            return false
        }

        $('#option_name_en').val('')
        $('#option_name_nl').val('')

        var html ='<div class="row col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 newOptionDiv"' +
            'style="float:left;margin-right: 10px;">' +
            '<div' +
            '    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">' +
            '    <div class="form-group">' +
            '        <label for="password" class="form-label">'+ dishValidation.option +' <span' +
            '                class="text-custom-muted">(English)</span></label>' +
            '        <div class="input-group">' +
            '            <input type="text" class="form-control name_en"' +
            '                   value="'+ name_en +'">' +
            '            <button' +
            '                class="input-group-btn btn btn-custom-gray btn-icon h-50px del-new-option"' +
            '                type="button"><i' +
            '                    class="fa-solid fa-xmark"></i></button>' +
            '        </div>' +
            '    </div>' +
            '</div>' +
            '<div' +
            '    class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">' +
            '    <div class="form-group">' +
            '        <label for="password" class="form-label">'+ dishValidation.option +' <span' +
            '                class="text-custom-muted">(Dutch)</span></label>' +
            '        <div class="input-group">' +
            '            <input type="text" class="form-control name_nl"' +
            '                   value="'+ name_nl +'">' +
            '        </div>' +
            '    </div>' +
            '</div>' +
            '</div>';
        $('#dish-option-div').append(html)
    })

    $(document).on('click', '.del-added-option-btn', function (){
        deletedOption.push($(this).attr('id'))
        $(this).parent().parent().parent().parent().remove()
    })

    $(document).on('click', '.del-new-option', function (){
        $(this).parent().parent().parent().parent().remove()
    })

    $(document).on('change', '#input-file', function () {

        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            alert($('#image_type_error').text());
            return false
        }

        var imgWidth = $(this).width();
        var imgHeight =$(this).height();
        if(imgWidth > 1080 || imgHeight > 1080){
            alert($('#image_size_error').text());
            return false
        }

        $('#img-preview').attr('style', 'height:40px !important;')
        readURL(this);
        $('#img-label').hide()
    });
});

function getIngredientsList(categoryId, type) {
    var id = $('#dishId').val()
    $.ajax({
        url: baseURL + '/menu/dish/getIngredientList/' + id,
        type: 'POST',
        data: {
            categoryId,
            type
        },
        success: function (response) {
            if (response.status == 200) {
                var ingredients = response.data
                var html = '<option value="">'+ dishValidation.select_ingred +'</option>'
                if (type == 'paid') {
                    $.each(ingredients, function (index, item) {
                        html += '<option value="' + item.id + '"> ' + item.name + '</option>'
                    });
                    $('#paidIngredient').html(html)
                } else {
                    $.each(ingredients, function (index, item) {
                        html += '<option value="' + item.id + '"> ' + item.name + '</option>'
                    });
                    $('#freeIngredient').html(html)
                }
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
}

function addIngredient(type) {
    var id = $('#dishId').val()
    var ingredientData;

    if (type == 'paid') {
        ingredientData = new FormData(document.getElementById('paidIngredientForm'));
        ingredientData.append('type', 'paid')
    } else {
        ingredientData = new FormData(document.getElementById('freeIngredientForm'));
        ingredientData.append('type', 'free')
    }

    $.ajax({
        url: baseURL + '/menu/dish/addIngredient/' + id,
        type: 'POST',
        processData: false,
        contentType: false,
        data: ingredientData,
        success: function (response) {
            if (response.status == 200) {
                var id = response.data.id

                if (type == 'paid') {
                    $('#no-paid-ing-tr').remove()
                    var html = '<tr id="dishIngredient'+ id +'">' +
                        '<td class="text-center"><img' +
                        '        src="'+ response.data.ingredient.image +'"' +
                        '        class="img-fluid me-15px" alt="ingredient img 1"/></td>' +
                        '<td class="text-center"><input type="text"' +
                        '                               class="form-control text-center w-10r m-auto"' +
                        '                               value="' + response.data.ingredient.name + '" readonly/>' +
                        '<td class="text-center"><input type="text"' +
                        '                               class="form-control text-center w-10r m-auto"' +
                        '                               value="' + response.data.ingredient.category.name + '" readonly>' +
                        '</td>' +
                        '<td class="text-custom-muted-1 text-center">' +
                        '    <div class="input-group w-5r m-auto">' +
                        '        <span class="input-group-text"' +
                        '              id="basic-addon1">€</span>' +
                        '        <input type="number" id="price' + id + '" class="form-control m-auto"' +
                        '               value="' + response.data.price + '" readonly>' +
                        '    </div>' +
                        '</td>' +
                        '<td class="text-center">' +
                        '    <div class="">' +
                        '        <a class="btn btn-custom-yellow btn-icon me-4 paid-ingredient-edit-btn"' +
                        '           id="paid-ingredient-edit' + id + '" data-id="' + id + '"' +
                        '           tabindex="0" href="javascript:void(0);">' +
                        '            <i class="fa-solid fa-pen-to-square"></i>' +
                        '        </a>' +
                        '        <a class="btn btn-custom-yellow btn-icon paid-ingredient-del-btn del-dish-ingredient"' +
                        '           id="paid-ingredient-delete' + id + '"' +
                        '           data-bs-toggle="modal" data-id="' + id + '"' +
                        '           data-bs-target="#deleteAlertModal">' +
                        '            <i class="fa-regular fa-trash-can"></i>' +
                        '        </a>' +
                        '        <a class="btn btn-custom-yellow btn-default d-block paid-ingredient-save-btn" style="display: none !important;"' +
                        '           id="paid-ingredient-save' + id + '" data-id="' + id + '">' +
                        '            <span class="align-middle">'+ dishValidation.save_btn +'</span>' +
                        '        </a>' +
                        '    </div>' +
                        '</td>' +
                        '</tr>';
                    $('#paidIngredientTbody').append(html)
                    $('#paidIngredientCategory').val('')
                    $('#paid-price').val('')
                    $('#paidIngredient').html('<option value="">'+ dishValidation.select_ingred+'</option>')
                } else {
                    $('#free-paid-ing-tr').remove()
                    var html = "<tr id='dishIngredient"+ id +"'>" +
                        "<td class='text-center'>" +
                        "    <img" +
                        "        src='"+ response.data.ingredient.image +"'" +
                        "        class='img-fluid me-15px' alt='ingredient img 1'/></td>" +
                        "<td class='text-center'><input type='text'" +
                        "                               class='form-control text-center w-10r m-auto'" +
                        "                               value='" + response.data.ingredient.name + "' readonly/>" +
                        "<td class='text-center'><input type='text'" +
                        "                               class='form-control text-center w-10r m-auto'" +
                        "                               value='" + response.data.ingredient.category.name + "' readonly/>" +
                        "</td>" +
                        "<td class='text-center'>" +
                        "    <div class=''>" +
                        "        <a class='btn btn-custom-yellow btn-icon free-ingredient-delete-btn del-dish-ingredient'" +
                        "           data-bs-toggle='modal'" +
                        "           data-bs-target='#deleteAlertModal' data-id='" + id + "' id='free-ingredient-delete" + id + "'>" +
                        "            <i class='fa-regular fa-trash-can'></i>" +
                        "        </a>" +
                        "    </div>" +
                        "</td>" +
                        "</tr>";
                    $('#freeIngredientTbody').append(html)
                    $('#freeIngredientCategory').val('')
                    $('#freeIngredient').html('<option value="">'+ dishValidation.select_ingred+'</option>')
                }
                toastr.success(dishValidation.save_ingredient)
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
}

function updateDishData() {
    var id = $('#dishId').val()
    var dishData = new FormData(document.getElementById('editDishForm'));

    dishData.append('deletedOption',deletedOption);

    $('.addedOptionDiv').each(function(i, obj) {
        var newArray = {
            id: $(this).find('input.id').val(),
            name_en:$(this).find('input.name_en').val(),
            name_nl:$(this).find('input.name_nl').val()
        }
        dishData.append('addedOption[]', JSON.stringify(newArray))
    });

    $('.newOptionDiv').each(function(i, obj) {
        var newArray = {
            name_en:$(this).find('input.name_en').val(),
            name_nl:$(this).find('input.name_nl').val()
        }
        dishData.append('newOption[]', JSON.stringify(newArray))
    });

    $.ajax({
        url: baseURL + '/menu/dish/updateDish/' + id,
        type: 'POST',
        processData: false,
        contentType: false,
        data: dishData,
        success: function (response) {
            if (response.status == 200) {
                toastr.success(response.message)

                setTimeout(function(){ window.location.reload(); }, 500);
            }else{
                alert(response.message)
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            toastr.error(errorMessage)
            // alert(errorMessage);
        }
    })
}

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}
