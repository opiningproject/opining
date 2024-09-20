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
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.closest(".mb-3"));
            $('#finance-error').hide()
        },
    });
});
