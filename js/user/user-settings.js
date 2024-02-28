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
            debugger
            toastr.success('Settings updated')
            return true;
        }
    });
    $.validator.addMethod(
        "alphaRegex",
        function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Only Alphabet"
    );
    $('#image').change(function (e) {

        var type = e.target.files[0].type;

        if(type != 'image/jpeg' && type != 'image/png' && type != 'image/jpg')
        {
            alert('Please upload valid image.');

            $("#image").val('');
            return false;
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

