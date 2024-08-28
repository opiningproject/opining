$(document).ready(function(){
    $("#mobilesearchToggle").click(function(){
      $(".searcheaderBox").toggleClass("toggled");
    });

    $("#closeSearch").click(function(){
        $(".searcheaderBox").removeClass("toggled");
      });

    //   function checkScreenSize() {
    //     if ($(window).width() <= 767) {
    //         $('.menu-sidebar').addClass('sticky');
    //     } else {
    //         $('.menu-sidebar').removeClass('sticky');
    //     }
    // }

    // // Add event listener for window resize
    // $(window).on('resize', checkScreenSize);
    // checkScreenSize()

  });

/*  $(document).ready(function() {
        var $swiperContainer = $('.swiper-container-mobile');
        console.log("$swiperContainer",$swiperContainer)
        var stickyOffset = $swiperContainer.offset().top;
        console.log("stickyOffset",stickyOffset)
        $(window).scroll(function() {
            console.log("stickyOffset",stickyOffset, "12", $(window).scrollTop())
            if ($(window).scrollTop() > stickyOffset) {
                console.log("$swiperContainer1231",$swiperContainer)
                $swiperContainer.addClass('mobile-slider-sticky');
            } else {
                $swiperContainer.removeClass('mobile-slider-sticky');
            }
        });
});*/
/*$(document).ready(function() {
    // Initialize the function
    function initStickySwiper() {
        var $swiperContainer = $('.swiper-container-mobile');

        if ($swiperContainer.length) {
            var stickyOffset = $swiperContainer.offset().top;

            $(window).scroll(function() {
                if ($(window).scrollTop() > stickyOffset) {
                    $swiperContainer.addClass('mobile-slider-sticky');
                } else {
                    $swiperContainer.removeClass('mobile-slider-sticky');
                }
            });
        } else {
            console.log("No swiper container found.");
        }
    }

    // Call the function on document ready
    initStickySwiper();

    // Reinitialize if data is loaded dynamically (example)
    // Assuming you have a function to reload or fetch data
    function fetchDataAndInitialize() {
        // Fetch or load data...
        // After data is loaded
        initStickySwiper(); // Reinitialize
    }

    // Example trigger for dynamic data load
    $('#loadMoreData').on('click', function() {
        fetchDataAndInitialize();
    });
});*/
$(document).ready(function() {
    // Function to handle sticky behavior
    function initStickySwiper() {
        var $swiperContainer = $('.swiper-container-mobile');
        // Ensure the swiper container exists in the DOM
        if ($swiperContainer.length > 0) {
            // If the container does not exist, add it to the DOM (optional)
            // This can be a fallback placeholder if you want the sticky behavior regardless
            $('body').prepend('<div class="swiper-container-mobile"></div>');
            $swiperContainer = $('.swiper-container-mobile');
        }

        // Get the initial offset of the container
        var stickyOffset = $swiperContainer.offset().top;

        // Attach the scroll event listener
        $(window).scroll(function() {
            if ($(window).scrollTop() > stickyOffset) {
                $swiperContainer.addClass('mobile-slider-sticky');
            } else {
                $swiperContainer.removeClass('mobile-slider-sticky');
            }
        });
    }

    // Call the function on document ready
    initStickySwiper();
});




  $(document).ready(function() {

    // function applyStickySlider() {
    //     var windowWidth = $(window).width();
    //     var elementTop = $('.swiper-container-mobile').offset().top;
    //     var elementHeight = $('.swiper-container-mobile').outerHeight();

    //     if (windowWidth <= 767) {
    //         $(window).scroll(function() {
    //             var windowTop = $(this).scrollTop();

    //             if (windowTop >= elementTop) {
    //                 $('.swiper-container-mobile').addClass('mobile-slider-sticky');
    //             } else {
    //                 $('.swiper-container-mobile').removeClass('mobile-slider-sticky');
    //             }

    //             if (windowTop === 0) {
    //                 $('.swiper-container-mobile').removeClass('mobile-slider-sticky');
    //             }
    //         });
    //     } else {
    //         // Ensure to remove the sticky class and padding if screen width is above 768px
    //         $('.swiper-container-mobile').removeClass('mobile-slider-sticky');
    //         $(window).off('scroll'); // Remove scroll event handler for larger screens
    //     }
    // }

    // applyStickySlider(); // Apply on page load

    // $(window).resize(function() {
    //     applyStickySlider(); // Reapply on window resize
    // });
});

$(document).on('click', '.category-element', function() {
    var cardCountBeforeClick = $('.category-list-section .food-detail-card').length;

    console.log("cardCountBeforeClick", cardCountBeforeClick);

    performActionsThatChangeCardCount(function() {
        var cardCountAfterClick = $('.category-list-section .food-detail-card').length;
        // Update class based on the new card count
        if (cardCountAfterClick >= 0) {
            $('.custom-section.category-section').addClass('swiper-container-mobile');
        } else {
            $('.custom-section.category-section').removeClass('swiper-container-mobile');
        }
    });
});

// Function that performs actions and accepts a callback to be executed after completion
function performActionsThatChangeCardCount(callback) {
    setTimeout(function() {
        callback();
    }, 100); // Adjust the timeout as needed
}


