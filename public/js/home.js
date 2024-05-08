var swiper = new Swiper(".category-swiper-slider", {
    slidesPerView: 1,
    spaceBetween: 4,
    loop: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: false,
    breakpoints: {
        640: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        768: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 8,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 8,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 5,
            spaceBetween: 20,
        },
        1700: {
            slidesPerView: 7,
            spaceBetween: 20,
        },
        1800: {
            slidesPerView: 7,
            spaceBetween: 20,
        },
        1920: {
            slidesPerView: 8,
            spaceBetween: 20,
        },
        2560: {
            slidesPerView: 11,
            spaceBetween: 20,
        },
    },
});

$(document).on('keyup', '#search-dish', function () {
    var search = $(this).val();

    let searchParams = new URLSearchParams(window.location.search)
    const cat_id = searchParams.get('cat_id');

    $.ajax({
        url: baseURL + '/dish/searchDish?cat_id='+cat_id,
        type: 'POST',
        data: {
            search
        },
        datatype: 'json',
        success: function (response) {
            $('.dish-details-div').html(response)
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
})

$(document).on("click", "#prev-cat, #next-cat", function () {

    var direction = $(this).attr("id") === "prev-cat" ? "prev" : "next";
    var categoryElement = $(this).closest(".category-element");

    if(direction === "prev") {
        var prevElement = categoryElement.prev(".category-element");
        if(prevElement.length > 0) {
            categoryElement.insertBefore(prevElement);

            updateOrderInDatabase(categoryElement, prevElement.data("id"), prevElement.data("sort-order"),prevElement);
        }
    } else {
        var nextElement = categoryElement.next(".category-element");
        if(nextElement.length > 0) {
            categoryElement.insertAfter(nextElement);

            updateOrderInDatabase(categoryElement, nextElement.data("id"), nextElement.data("sort-order"),nextElement);
        }
    }
});


function updateOrderInDatabase(movedElement, replacedId, replacedSortOrder,replacedElement) {
    var movedId = movedElement.data("id"); // Assuming you have a data-id attribute to store the category ID
    var movedSortOrder =  movedElement.attr("data-sort-order")
    var replacedSortOrder = replacedElement.attr("data-sort-order");
    // Send AJAX request to update order in database for the moved and replaced elements

    $.ajax({
        url: baseURL + '/category/update/sort-order',
        method: "POST",
        data: { movedId: movedId, replacedId: replacedId, replacedSortOrder: replacedSortOrder, movedSortOrder: movedSortOrder },
        success: function(response) {

            toastr.success(response.message)
            // Update data sort order in slider
            replacedElement.attr('data-sort-order', movedSortOrder);
            movedElement.attr('data-sort-order', replacedSortOrder);
        },
        error: function(xhr, status, error) {
            console.error("Error updating order in database: " + error);
        }
    });

}
