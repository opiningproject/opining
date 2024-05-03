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

