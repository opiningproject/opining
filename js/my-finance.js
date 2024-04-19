$(document).ready(function () {
    $('.validate-admin').validate({
        rules: {
            password: {
                required: true
            },
        },
        messages: {
            password: {
                required: 'Please enter Password.',
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
