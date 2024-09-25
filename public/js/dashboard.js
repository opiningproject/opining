$(function () {
    $('.dropdown-menu a').on('click', function(e) {
        e.preventDefault();

        var currentText = $('.dropdown-toggle').text().trim();
        var selectedText = $(this).text().trim();

        $('.dropdown-toggle').text(selectedText);

        $(this).text(currentText);

        // Send the selected date range to the backend via AJAX
        console.log("baseURL + 'dashboard/data'", baseURL + '/dashboard/data')
        $.ajax({
            url: baseURL + '/dashboard/statistics', // Route to fetch data
            type: 'GET',
            data: {
                date_range: selectedText
            },
            success: function(response) {
                // Update the counts on the page with the returned data
                // $('#totalUser').text(response.totalUser);
                $('#totalOrders').text(response.totalOrders);
                $('.newUsers').text(response.newUsers);
            }
        });
    });
})
