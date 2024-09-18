$(function () {
    $('.dropdown-menu a').on('click', function(e) {
        // console.log("innn");
        e.preventDefault(); // Prevent the default link behavior

        var selectedText = $(this).text().trim();
        $('.dropdown-toggle').text(selectedText);

        // Send the selected date range to the backend via AJAX
        // dashboard/data
        console.log("baseURL + 'dashboard/data'", baseURL + '/dashboard/data')
        $.ajax({
            url: baseURL + '/dashboard/statistics', // Route to fetch data
            type: 'GET',
            data: {
                date_range: selectedText
            },
            success: function(response) {
                // Update the counts on the page with the returned data
                $('#totalUser').text(response.totalUser);
                $('#totalOrders').text(response.totalOrders);
                $('#newUsers').text(response.newUsers);
            }
        });
    });
})
