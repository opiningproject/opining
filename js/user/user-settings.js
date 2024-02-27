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
    $('#image').change(function () {
        var ext = this.value.match(/\.(.+)$/)[1];
        switch (ext) {
            case 'jpg':
            case 'jpeg':
            case 'png':
            case 'gif':
                $('#uploadButton').attr('disabled', false);
                break;
            default:
                alert('This is not an allowed file type.');
                this.value = '';
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

