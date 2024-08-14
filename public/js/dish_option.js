
$(function () {

    $("#addDishOptionForm").validate({
        ignore: [],
        rules: {
            image:{
                required: true
            },
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

    $("#ingredientTbody").sortable({
        update: function() {
            updateRowOrder();
        }
    });

    function updateRowOrder(){

        var order = [];

        $('tr.ingredientRow').each(function(index,element) {
            order.push({
                id: $(this).attr('data-id'),
                position: index+1
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({

            type: "POST",
            url: "dish-option/updateingredientRowOrder",
            cursor: 'move',
            data: {

                order:order,

            },
            success: function(response) {

            }
        });
    }

    $(document).on('click', '.del-ing-btn', function () {

        var id = $(this).attr('data-id');

        $.ajax({
            url: baseURL + '/menu/dish-option/checkAttachedDish/' + id,
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

    $(document).on('click', '#delete-ingredient-btn', function () {
        var id = $('#ingredientId').val()

        $.ajax({
            url: 'dish-option/' + id,
            type: 'DELETE',
            success: function (response) {
                if (response.status == 200) {
                    $('#ingredient-tr' + id).remove()
                    $('#deleteAlertModal').modal('hide')
                    toastr.success(response.message)
                } else {
                    toastr.error(response.message)
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })

    $(document).on('click', '.edit-ing-btn', function () {
        var id = $(this).attr('data-id');
        $('#catId' + id).prop('disabled', false).removeClass('read-only')
        $('#dish-list' + id).prop('disabled', false)
        $('#is_edited' + id).val(1)
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
        var addedDish = []
        var deletedDish = $('#deleted-dish' + id).val().substring(1);

        var ingredientData = new FormData();
        /*if($('#ing-image'+id).val() != ''){
            ingredientData.append('image', $('#ing-image'+id).prop('files')[0])
        }*/
        ingredientData.append('deletedDish', deletedDish)
        ingredientData.append('category_id', category_id)
        ingredientData.append('name_en', name_en)
        ingredientData.append('name_nl', name_nl)

        if(name_en == ''){
            $('#name_en' + id).focus();
            return false
        }

        if(name_nl == ''){
            $('#name_nl' + id).focus();
            return false
        }

        $('.new-dish').each(function(i, obj) {
            addedDish.push($(this).attr('data-dish-id'))
            ingredientData.append('addedDish[]', $(this).attr('data-dish-id'))
        });

        $.ajax({
            url: baseURL + '/menu/dish-option/update/' + id,
            type: 'POST',
            processData: false,
            contentType: false,
            data: ingredientData,
            success: function (response) {
                if (response.status == 200) {
                    toastr.success(response.message)
                    setTimeout(function(){ location.reload() }, 500);
                }else{
                    toastr.error(response.message)
                }
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })

    })

    $(document).on('change', '#per_page_dropdown', function () {
        var url = this.value;
        window.open(url, '_parent');
    })

    $(document).on('click', '.update-ing-status', function () {

        var id = $(this).val()
        var status = 0;

        if ($(this).prop('checked')) {
            status = 1;
        }

        $.ajax({
            url: baseURL + '/menu/dish-option/update-status/' + id,
            type: 'POST',
            data: {
                status
            },
            success: function (response) {
                toastr.success(response.message)
            },
            error: function (response) {
                var errorMessage = JSON.parse(response.responseText).message
                alert(errorMessage);
            }
        })
    })

    $(document).on('change', '#input-file', function () {

        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
            alert($('#image_type_error').text());
            return false
        }

        $('#img-preview').attr('style', 'height:40px !important;')
        readURL(this);
        $('#img-label').hide()
    });

    $(document).on('change', '.ing-image-file', function () {
        var id = $(this).attr('data-id')

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

        editReadURL(this, id);
    });
    // console.log("ingValidationMsg.less",ingValidationMsg.less, ingValidationMsg.more)
    $(document).on('click', '.more-less-text', function (){
        console.log("$(this).text()",$(this).text())
        if($(this).text() == '+ More' || $(this).text() == '+ (More)'){
            $(this).text('- Less')
        }else{
            $(this).text('+ More')
        }
    })

    $(document).on('change', '.dish-dropdown', function () {
        var id = $(this).val()
        var ingredientId = $(this).attr('data-id')
        var dishName = $(this).find(':selected').attr('data-name')
        console.log("in",id, "ingredientId", ingredientId, "dishName", dishName)

        var html = '<span class="badge text-bg-yellow mt-1">' + dishName + '<a ' +
            'href="javascript:void(0);"><i class="fa-solid fa-xmark align-middle del-dish-icon new-dish new-added-dish' + ingredientId + '" data-dish-id="' + id + '" data-id="' + ingredientId + '" data-name="' + dishName + '"></i></a></span>';
        $('.dish-tray' + ingredientId).append(html)
        $(this).find(':selected').remove()
        $(this).val('')
    })

    $(document).on('click', '.new-dish', function () {

        var ingId = $(this).attr('data-id')
        var id = $(this).attr('data-dish-id')
        var name = $(this).attr('data-name')

        $('#dish-list' + ingId).append("<option value='" + id + "' data-name='" + name + "'>" + name + "</option>")
        $(this).parent().parent().remove()
    })

    $(document).on('click', '.existing-dish', function () {
        var ingId = $(this).attr('data-id')

        if ($('#is_edited' + ingId).val() == '0') {
            return false
        }
        var id = $(this).attr('data-dish-id')
        var ingDishId = $(this).attr('data-dish-ing-id')
        var name = $(this).attr('data-name')

        var dishIds = $('#deleted-dish' + ingId).val()
        dishIds += ',' + ingDishId
        $('#deleted-dish' + ingId).val(dishIds)
        $(this).parent().parent().remove()

        $('#dish-list' + ingId).append("<option value='" + id + "' data-name='" + name + "'>" + name + "</option>")
    })

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img-preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function editReadURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#ing-img-preview'+id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

});
