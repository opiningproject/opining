function favorite(dish_id) {
    $.ajax({
        url: baseURL + '/favorite',
        type: 'POST',
        data: {
            dish_id
        },
        success: function (response) {
            console.log('success')
            if (response.status == 2) {
                $('#signInModal').modal('show');
                return false;
            }
            $("#unfavorite-icon-" + dish_id).addClass('d-none');
            $("#favorite-icon-" + dish_id).removeClass('d-none');
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

function unFavorite(dish_id) {
    $.ajax({
        url: baseURL + '/unFavorite',
        type: 'POST',
        data: {
            dish_id
        },
        success: function (response) {
            $("#unfavorite-icon-" + dish_id).removeClass('d-none');
            $("#favorite-icon-" + dish_id).addClass('d-none');
        },
        error: function (response) {
            var errorMessage = JSON.parse(response.responseText).message
            alert(errorMessage);
        }
    })
}

$(window).on("load", function () {
    var showModal = " < ? php echo $showModal; ? > ";
    if (showModal == 1) {
        $("#signInModal").modal("show");
    }
});

$(document).ready(function () {

    var swiper = new Swiper(".category-swiper-slider", {
        slidesPerView: 3,
        spaceBetween: 6,
        // loop: true,
        // autoplay: {
        //     delay: 1000,
        //     disableOnInteraction: false,
        // },
        autoplay: true,
        pagination: false,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            375: {
                slidesPerView: 3,
                spaceBetween: 10,
                autoplay: false,
            },
            425: {
                slidesPerView: 4,
                spaceBetween: 10,
                autoplay: false,
            },
            575: {
                slidesPerView: 3,
                spaceBetween: 10,
                autoplay: false,
            },
            640: {
                slidesPerView: 3,
                spaceBetween: 20,
                autoplay: false,
            },
            700: {
                slidesPerView: 3,
                spaceBetween: 20,
                autoplay: false,
            },
            758: {
                slidesPerView: 4,
                spaceBetween: 20,
                autoplay: false,
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 20,
                autoplay: false,
            },
            800: {
                slidesPerView: 4,
                spaceBetween: 20,
                autoplay: false,
            },
            988: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1100: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            1300: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            1400: {
                slidesPerView: 4,
                spaceBetween: 20,
            },
            1700: {
                slidesPerView: 6,
                spaceBetween: 30,
            },
            1800: {
                slidesPerView: 6,
                spaceBetween: 30,
            },
            1920: {
                slidesPerView: 6,
                spaceBetween: 30,
            },
            2560: {
                slidesPerView: 6,
                spaceBetween: 30,
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

});
