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

  $(document).ready(function() {
    function applyStickySlider() {
        var windowWidth = $(window).width();
        var elementTop = $('.swiper-container-mobile').offset().top;
        var elementHeight = $('.swiper-container-mobile').outerHeight();

        if (windowWidth <= 767) {
            $(window).scroll(function() {
                var windowTop = $(this).scrollTop();

                if (windowTop >= elementTop) {
                    $('.swiper-container-mobile').addClass('mobile-slider-sticky');
                    $('body').css('padding-top', elementHeight + 'px'); 
                } else {
                    $('.swiper-container-mobile').removeClass('mobile-slider-sticky');
                    $('body').css('padding-top', '0'); 
                }

                if (windowTop === 0) {
                    $('.swiper-container-mobile').removeClass('mobile-slider-sticky');
                    $('body').css('padding-top', '0'); 
                }
            });
        } else {
            // Ensure to remove the sticky class and padding if screen width is above 768px
            $('.swiper-container-mobile').removeClass('mobile-slider-sticky');
            $('body').css('padding-top', '0');
            $(window).off('scroll'); // Remove scroll event handler for larger screens
        }
    }

    applyStickySlider(); // Apply on page load

    $(window).resize(function() {
        applyStickySlider(); // Reapply on window resize
    });
});