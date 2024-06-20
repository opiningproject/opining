$(function () {
    $("#user-profile-form").validate({
        ignore: [],
        rules: {
            first_name: {
                alphaRegex: "^[a-zA-Z]+$"
            },
            last_name: {
                alphaRegex: "^[a-zA-Z]+$"
            }
        },
        submitHandler: function (form) {
            toastr.success(validationMsg.settings_update_success)
            return true;
        }
    });
    $.validator.addMethod(
        "alphaRegex",
        function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        validationMsg.alpha_regex
    );
    $('#image').change(function (e) {

        var type = e.target.files[0].type;
        var extension = e.target.files[0].name.split('.').pop()

        if(type != 'image/jpeg' && type != 'image/png' && type != 'image/jpg')
        {
            alert('Please upload valid image.');

            $("#image").val('');
            return false;
        }else{
            if(extension != 'jpeg' && extension != 'png' && extension != 'jpg'){
                alert('Please upload valid image.');

                $("#image").val('');
                return false;
            }
        }
    });
})

function readMore(id) {
    $('#close-' + id).show()
    $('#read-more-' + id).hide()

    $("#order-ingredient-" + id).removeClass('line-clamp-2');
}

function hideReadMore(id) {
    $('#close-' + id).hide()
    $('#read-more-' + id).show()

    $("#order-ingredient-" + id).addClass('line-clamp-2');
}


function checkScreenSize() {
    if ($(window).width() <= 767) {
        $('body').addClass('title-becomes');
    } else {
        $('body').removeClass('title-becomes');
    }
}
checkScreenSize();