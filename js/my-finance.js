$(document).ready(function () {
    $('.validate-admin').validate({
        rules: {
            password: {
                required: true
            },
        },
        messages: {
            password: {
                required: financeValidationMsg.financePassword,
            },
        },
        submitHandler: function (form) {
            form.submit();
        }
    });
});
