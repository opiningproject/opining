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
            percentage_off: {
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
            addFreeIngredient('free');
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
            addFreeIngredient('paid');
        }
    });


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
                alert(errorMessage);
            }
        })
    })

    $(document).on('change', '#freeIngredientCategory', function () {
        var catId = $(this).val()
        if (catId != '') {
            getIngredientsList(catId, 'free')
        } else {
            $('#freeIngredient').html('<option value="">Select Ingredient</option>')
        }
    })

    $(document).on('change', '#paidIngredientCategory', function () {
        var catId = $(this).val()
        if (catId != '') {
            getIngredientsList(catId, 'paid')
        } else {
            $('#paidIngredient').html('<option value="">Select Ingredient</option>')
        }
    })


    $(document).on('change', '#update-dish', function () {
        var id = $('#dishId').val()

        var name_en = $('#name_en').val()
        var name_nl = $('#name_nl').val()
        var category_id = $('#category_id').val()
        var price = $('#price').val()
        var percentage_off = $('#percentage_off').val()
        var qty = $('#qty').val()
        var desc_en = $('#desc_en').val()
        var desc_nl = $('#desc_nl').val()
        var out_of_stock = $('#outofstock').is(':checked') ? 1 : '0'

            $.ajax({
                url: baseURL + '/menu/update-dish/' + id,
                type: 'PATCH',
                data: {
                    name_en,
                    name_nl,
                    category_id,
                    price,
                    percentage_off,
                    qty,
                    desc_en,
                    desc_nl,
                    out_of_stock
                },
                success: function (response) {
                    if (response.status == 200) {
                        location.reload()
                    }

                },
                error: function (response) {
                    var errorMessage = JSON.parse(response.responseText).message
                    alert(errorMessage);
                }
            })
    })
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
                var html = '<option value="">Select Ingredient</option>'
                if (type == 'paid') {
                    $.each(ingredients, function (index, item) {
                        html += '<option value="' + item.id + '"> ' + item.name_en + '</option>'
                    });
                    $('#paidIngredient').html(html)
                } else {
                    $.each(ingredients, function (index, item) {
                        html += '<option value="' + item.id + '"> ' + item.name_en + '</option>'
                    });
                    $('#freeIngredient').html(html)
                }
            }
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function addFreeIngredient(type) {
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
                    var html = '<tr>' +
                        '<td class="text-center"><img' +
                        '        src="images/american_cheese_img.svg"' +
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
                        '        <input type="number" class="form-control m-auto"' +
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
                        '        <a class="btn btn-custom-yellow btn-icon paid-ingredient-del-btn"' +
                        '           id="paid-ingredient-delete' + id + '"' +
                        '           data-bs-toggle="modal" data-id="' + id + '"' +
                        '           data-bs-target="#deleteAlertModal">' +
                        '            <i class="fa-regular fa-trash-can"></i>' +
                        '        </a>' +
                        '        <a class="btn btn-custom-yellow btn-default d-block paid-ingredient-save-btn" style="display: none !important;"' +
                        '           id="paid-ingredient-save' + id + '" data-id="' + id + '">' +
                        '            <span class="align-middle">Save</span>' +
                        '        </a>' +
                        '    </div>' +
                        '</td>' +
                        '</tr>';
                    $('#paidIngredientTbody').append(html)
                    $('#paidIngredientCategory').val('')
                    $('#paidIngredient').html('<option value="">Select Ingredient</option>')
                } else {
                    var html = "<tr>" +
                        "<td class='text-center'>" +
                        "    <img" +
                        "        src=''" +
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
                        "        <a class='btn btn-custom-yellow btn-icon free-ingredient-delete-btn'" +
                        "           data-bs-toggle='modal'" +
                        "           data-bs-target='#deleteAlertModal' data-id='" + id + "' id='free-ingredient-delete" + id + "'>" +
                        "            <i class='fa-regular fa-trash-can'></i>" +
                        "        </a>" +
                        "    </div>" +
                        "</td>" +
                        "</tr>";
                    $('#freeIngredientTbody').append(html)
                    $('#freeIngredientCategory').val('')
                    $('#freeIngredient').html('<option value="">Select Ingredient</option>')
                }
            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

