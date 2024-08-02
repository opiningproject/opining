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

$(function (){
    $('#scroll-top').click(function (){
        $(window).scrollTop(0);
    })
})

var swiper = '';
$(document).ready(function () {

    swiper = new Swiper(".category-swiper-slider", {
        slidesPerView: 3,
        spaceBetween: 12,
        // loop: true,
        // autoplay: {
        //     delay: 1000,
        //     disableOnInteraction: false,
        // },
        // autoplay: true,
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

  function activateSlide(categoryId) {

    // Find the index of the slide with the given category ID
    var slideIndex = $('.swiper-slide[data-category-id="' + categoryId + '"]').index();
    // Check if the slide index is valid
    if (slideIndex >= 0) {
        // Use Swiper's slideTo method to make the specific slide active
        swiper.slideTo(slideIndex);

        // Remove active class from all slides
        $('.swiper-slide').removeClass('selected-cart-active swiper-slide-active');

        // Add active class to the selected slide
        $('.swiper-slide[data-category-id="' + categoryId + '"]').addClass('selected-cart-active swiper-slide-active');
    }
}


function getDishes(catId) {

    if(!catId) {
        catId = $('#view-all-dishes').attr('data-category-id');
    }
    activateSlide(catId);

    $.ajax({
        url: `${baseURL}/get-dishes/${catId}`,
        type: 'GET',
        success: function (response) {

            window.history.pushState('',app_name, '/user/dashboard/'+catId);

            // update view all button attribute id
            $('#view-all-dishes').attr('data-category-id',catId);

            $('.section-title.dish-list').text(response.cat_name)
            $('.dish-details-div').html(response.data)
        },
        error: function (response) {}
    })

}


function checkScreenSize() {
    if ($(window).width() <= 767) {
        $('body').addClass('body-bg-mobile');
        var invoiceHeight = $('.cartSidebarCustom .bill-detail-invoice').height();
        var newHeight = invoiceHeight + 20;
        $('.cartSidebarCustom .cartoffCanvas').css('padding-bottom', newHeight + 'px');

        if ($('.pills-delivery-tab.active').data('type') == "1") {
            $('.cartSidebarCustom .cartoffCanvas').css('padding-bottom', newHeight + 'px');
        } else {
            newHeight = invoiceHeight - 20
            $('.cartSidebarCustom .cartoffCanvas').css('padding-bottom', newHeight + 'px');
        }
    } else {
        $('body').removeClass('body-bg-mobile');
    }
}

checkScreenSize()
// Add event listener for window resize
$(window).on('resize', checkScreenSize);
