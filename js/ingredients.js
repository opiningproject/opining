$(function () {

    $("#addIngredientForm").validate({
        rules: {
            name_en: {
                required: true
            },
            name_nl: {
                required: true
            },
            category_id: {
                required: true
            }
        },
        submitHandler: function (form) {
            form.submit()
        }
    });

    $(document).on('click', '.del-ing-btn', function () {

        var id = $(this).attr('data-id');

        $.ajax({
            url: baseURL + '/menu/ingredients/checkAttachedDish/' + id,
            type: 'GET',
            success: function (response) {
                if (response.status == 200) {
                    $('#ingredientId').val(id)
                    $('#deleteAlertModal').modal('show')
                } else {
                    $('#deleteAlertModalMsg').modal('show')
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('click', '#delete-category-btn', function () {
        var id = $('#ingredientId').val()

        $.ajax({
            url: 'ingredients/' + id,
            type: 'DELETE',
            success: function (response) {
                console.log('success')
                console.log(response)
                window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })

    $(document).on('click', '.edit-ing-btn', function () {
        var id = $(this).attr('data-id');
        $('#catId' + id).prop('disabled', false)
        $(this).siblings('a.save-edit-btn').show()
        $(this).parent().parent().siblings().children('input').attr("readonly", false).focus();
        $(this).siblings('a.del-ing-btn').hide()
        $(this).parent().parent().siblings().children('img').hide()
        $(this).parent().parent().siblings().children('div.imageupload-box').show()
        $(this).hide()
    })

    $(document).on('click', '.save-edit-btn', function () {
        var id = $(this).attr('data-id');

        var category_id = $('#catId' + id).val()
        var name_en = $('#name_en' + id).val()
        var name_nl = $('#name_nl' + id).val()

        $.ajax({
            url: baseURL + '/menu/ingredients/' + id,
            type: 'PUT',
            data: {
                category_id,
                name_en,
                name_nl
            },
            success: function (response) {
                if (response.status == 200) {
                    $('#catId' + id).prop('disabled', true)
                    $('#name_en' + id).prop("readonly", true);
                    $('#name_nl' + id).prop("readonly", true);
                    $('#del-btn' + id).show()
                    $('#edit-btn' + id).show()
                    $('#save-btn'+id).attr('style', 'display:none !important')
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })

    $(document).on('click', '.update-ing-status', function () {

        var id = $(this).val()
        var status = 0;

        if ($(this).prop('checked')) {
            status = 1;
        }

        $.ajax({
            url: baseURL + '/menu/ingredients/update-status/' + id,
            type: 'POST',
            data: {
                status
            },
            success: function (response) {
                // window.location.reload();
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('change', '#input-file', function () {
        readURL(this);
        $('#img-label').hide()
    });

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

});

function saveIngredient() {
    var ingredientData = new FormData(document.getElementById('addIngredientForm'));

    $.ajax({
        url: baseURL + 'menu/ingredients/category',
        type: 'POST',
        processData: false,
        contentType: false,
        data: ingredientData,
        success: function (response) {
            if (response.status == 200) {
                var id = response.data.id


                var html = '<tr id="ingredient-tr{{ $ingredient->id }}">' +
                    '<td scope="row" class="text-center">' +
                    '    <img' +
                    '        src="{{ asset(\'images/tomatoes-img.svg\')}}" class="img-fluid"' +
                    '        alt="ingredient img 1"/>' +
                    '    <div class="imageupload-box inline-imageupload-box mb-0"' +
                    '         style="display: none">' +
                    '        <label for="input-file" class="upload-file">' +
                    '            <input type="file" id="ing-image{{ $ingredient->id }}">' +
                    '            <img src="{{ asset(\'images/tomatoes-img.svg\')}}"' +
                    '                 alt="tomatoes image"' +
                    '                 class="img-fluid" width="25" height="25">' +
                    '            <p class="mb-0 text-lowercase" >Tomato.png</p>' +
                    '        </label>' +
                    '    </div>' +
                    '</td>' +
                    '<td class="text-center"><input type="text"' +
                    '                               class="form-control text-center w-10r m-auto" id="name_en{{ $ingredient->id }}"' +
                    '                               value="{{ $ingredient->name_en }}"' +
                    '                               readonly/></td>' +
                    '<td>' +
                    '    <div class="dropdown buttondropdown category-dropdown">' +
                    '        {{--<button class="form-control dropdown-toggle w-100"' +
                    '                type="button" data-bs-toggle="dropdown"' +
                    '                aria-expanded="false" disabled>' +
                    '            vegetables' +
                    '        </button>' +
                    '        <ul class="dropdown-menu">' +
                    '            <li><a class="dropdown-item"' +
                    '                   href="javascript:void(0);">Category 1</a></li>' +
                    '            <li><a class="dropdown-item"' +
                    '                   href="javascript:void(0);">Category 2</a></li>' +
                    '            <li><a class="dropdown-item"' +
                    '                   href="javascript:void(0);">Category 3</a></li>' +
                    '        </ul>--}}' +
                    '        <select disabled id="catId{{$ingredient->id}}">' +
                    '            @foreach ($ingredientCategory as $category) {' +
                    '            <option' +
                    '                value="{{ $category->id }}" {{ ($category->id == $ingredient->category_id) ? \'selected\' : \'\' }}>{{ (app()->getLocale() == \'en\') ? $category->name_en : $category->name_nl }}</option>' +
                    '            @endforeach' +
                    '        </select>' +
                    '    </div>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '    <div class="form-group mb-0">' +
                    '        <div' +
                    '            class="form-check form-switch form-switch-sm custom-switch justify-content-center ps-0">' +
                    '            <input' +
                    '                class="form-check-input green-check-input update-ing-status"' +
                    '                value="{{ $ingredient->id }}"' +
                    '                type="checkbox" role="switch" id="action" {{ ($ingredient->status == 1) ? \'checked\' : \'\'  }}>' +
                    '        </div>' +
                    '    </div>' +
                    '</td>' +
                    '<td>' +
                    '    <div class="table-add-dish-bar">' +
                    '        <button class="btn btn-light dropdown-toggle" type="button"' +
                    '                data-bs-toggle="dropdown" aria-expanded="false">' +
                    '            Select Dish name' +
                    '' +
                    '        </button>' +
                    '        <ul class="dropdown-menu custom-dropdown-menu">' +
                    '            <li><a class="dropdown-item"' +
                    '                   href="javascript:void(0);">Dish 1</a></li>' +
                    '            <li><a class="dropdown-item"' +
                    '                   href="javascript:void(0);">Dish 2</a></li>' +
                    '            <li><a class="dropdown-item"' +
                    '                   href="javascript:void(0);">Dish 3</a></li>' +
                    '        </ul>' +
                    '        <div class="table-dish-name">' +
                    '            @foreach ($ingredient->dishIngredient as $ingr) {' +
                    '' +
                    '            <span class="badge text-bg-yellow">{{ $ingr->dish->name_en }}<a' +
                    '                    href="javascript:void(0);"><i' +
                    '                        class="fa-solid fa-xmark align-middle"></i></a></span>' +
                    '            <span class="badge text-bg-yellow">margarita pizza<a' +
                    '                    href="javascript:void(0);"><i' +
                    '                        class="fa-solid fa-xmark align-middle"></i></a></span>' +
                    '' +
                    '            @endforeach' +
                    '' +
                    '            <a class="text-more-sm float-end lh-30px"' +
                    '               data-bs-toggle="collapse" href="#collapseDishRowTwo"' +
                    '               role="button" aria-expanded="false"' +
                    '               aria-controls="collapseDishRowTwo">+ 2 more</a>' +
                    '            <div class="moredishname-collapse collapse"' +
                    '                 id="collapseDishRowTwo">' +
                    '                <div' +
                    '                    class="card card-body bg-lightgray d-block py-2 px-0 border-0">' +
                    '                        <span class="badge text-bg-yellow">Big mac with' +
                    '                            Cheese<a href="javascript:void(0);"><i' +
                    '                                    class="fa-solid fa-xmark align-middle"></i></a></span>' +
                    '                    <span class="badge text-bg-yellow">Big mac with' +
                    '                            Cheese<a href="javascript:void(0);"><i' +
                    '                                class="fa-solid fa-xmark align-middle"></i></a></span>' +
                    '                </div>' +
                    '            </div>' +
                    '        </div>' +
                    '    </div>' +
                    '</td>' +
                    '<td class="text-center">' +
                    '    <div class="">' +
                    '        <a class="btn btn-custom-yellow btn-icon edit-ing-btn"' +
                    '           tabindex="0" data-id="{{ $ingredient->id }}">' +
                    '            <i class="fa-solid fa-pen-to-square"></i>' +
                    '        </a>' +
                    '        <a class="btn btn-custom-yellow btn-icon del-ing-btn"' +
                    '           data-id="{{ $ingredient->id }}">' +
                    '            <i class="fa-regular fa-trash-can"></i>' +
                    '        </a>' +
                    '        <a class="btn btn-custom-yellow btn-default save-edit-btn d-block"' +
                    '           style="display:none !important;" data-id="{{ $ingredient->id }}">' +
                    '            <span class="align-middle">Save</span>' +
                    '        </a>' +
                    '    </div>' +
                    '</td>' +
                    '</tr>'
                $('#paidIngredientTbody').append(html)
                $('#paidIngredientCategory').val('')
                $('#paidIngredient').html('<option value="">Select Ingredient</option>')

            }

        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

