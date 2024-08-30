$(document).ready(function () {
  $("#mobilesearchToggle").click(function () {
    $(".searcheaderBox").toggleClass("toggled");
  });

  $("#closeSearch").click(function () {
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


// $(document).ready(function () {
//   $(window).scroll(function () {
//     var scrollPosition = $(window).scrollTop();
//     var swiperOffset = $('.swiper-container-mobile').offset().top - 60;

//     if (scrollPosition >= (swiperOffset)) {
//       $('.swiper-container-mobile').addClass('sticky');
//     } else {
//       $('.swiper-container-mobile').removeClass('sticky');
//     }
//   });

// });

$(document).ready(function () {
  $(window).scroll(function () {
    $('.swiper-container-mobile').addClass('sticky');
    var scrollPosition = $(window).scrollTop();
    var swiperOffset = $('.category-section').offset().top;
    var categoryListOffset = $('.category-list-section').offset().top - 120;

    // if (scrollPosition >= swiperOffset) {
    //   $('.swiper-container-mobile').addClass('sticky');
    // } 

    if (scrollPosition < categoryListOffset) {
      $('.swiper-container-mobile').removeClass('sticky');
    }
  });
});

