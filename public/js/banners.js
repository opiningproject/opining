
$(function () {

    $("#add-banner-form").validate({
        ignore: [],
        rules: {
            image:{
                required: true
            },
            content_en: {
                required: true
            },
            content_nl: {
                required: true
            },
        },
        submitHandler: function (form) {
            form.submit()
        }
    });

    $("#bannerTbody").sortable({
        update: function() {
            updateRowOrder();
        }
    });

    function updateRowOrder(){

        var order = [];

        $('tr.bannerRow').each(function(index,element) {
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
            url: "banners/updateBannerRowOrder",
            cursor: 'move',
            data: {
                order:order,
            },
            success: function(response) {
            }
        });
    }

    $(document).on('click', '.del-banner-btn', function () {
        var id = $(this).attr('data-id');
        $('#bannerId').val(id)
        $('#deleteAlertModal').modal('show')
    })

    $(document).on('click', '#delete-ingredient-btn', function () {
        var id = $('#bannerId').val()
        console.log("id", id)
        $.ajax({
            url: 'banners/' + id,
            type: 'DELETE',
            success: function (response) {
                if (response.status == 200) {
                    $('#banner-tr' + id).remove()
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

    $(document).on('click', '.edit-banner-btn', function () {
        var id = $(this).attr('data-id');
        $('#is_edited' + id).val(1)
        $(this).siblings('a.save-edit-btn').show()
        $(this).parent().parent().siblings().children('input').attr("readonly", false).focus();
        $(this).siblings('a.del-banner-btn').hide()
        $(this).parent().parent().siblings().children('img').hide()
        $(this).parent().parent().siblings().children('div.imageupload-box').show()
        $(this).hide()
    })

    $(document).on('click', '.save-edit-btn', function () {

        var id = $(this).attr('data-id');
        var content_en = $('#content_en' + id).val()
        var content_nl = $('#content_nl' + id).val()
        var addedBanner = []

        var ingredientData = new FormData();
        if($('#banner-image'+id).val() != ''){
            ingredientData.append('image', $('#banner-image'+id).prop('files')[0])
        }
        ingredientData.append('content_en', content_en)
        ingredientData.append('content_nl', content_nl)

        if(content_en == ''){
            $('#content_en' + id).focus();
            return false
        }

        if(content_nl == ''){
            $('#content_nl' + id).focus();
            return false
        }

        $('.new-dish').each(function(i, obj) {
            addedBanner.push($(this).attr('data-dish-id'))
            ingredientData.append('addedBanner[]', $(this).attr('data-dish-id'))
        });

        $.ajax({
            url: baseURL + '/banners/update/' + id,
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
            url: baseURL + '/banners/update-status/' + id,
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

    $(document).on('change', '.banner-image-file', function () {
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

    $(document).on('click', '.more-less-text', function (){
        if($(this).text() == '+ More'){
            $(this).text('- '.ingValidationMsg.less)
        }else{
            $(this).text('+ '.ingValidationMsg.more)
        }
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
                $('#banner-img-preview'+id).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

});
