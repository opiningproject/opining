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

// $(document).ready(function() {
//   // Function to handle sticky behavior
//   function initStickySwiper() {
//       var $swiperContainer = $('.swiper-container-mobile');
//       var $productContainer = $('.category-list-section');

//       // Ensure the swiper container exists in the DOM
//       // if ($swiperContainer.length > 0) {
//       //     // If the container does not exist, add it to the DOM (optional)
//       //     // This can be a fallback placeholder if you want the sticky behavior regardless
//       //     $('body').prepend('<div class="swiper-container-mobile"></div>');
//       //     $swiperContainer = $('.swiper-container-mobile');
//       // }

//       // Get the initial offset of the container
//       // var stickyOffset = $productContainer.offset().top - 150;
//       var stickyOffset = $swiperContainer.offset().top;

//       // Attach the scroll event listener
//       $(window).scroll(function() {
//           if ($(window).scrollTop() > stickyOffset) {
//               $swiperContainer.addClass('mobile-slider-sticky');
//           } else {
//               $swiperContainer.removeClass('mobile-slider-sticky');
//           }
//       });
//   }

//   // Call the function on document ready
//   initStickySwiper();
// });


// $(document).on('click', '.category-slider .category-element', function() {
//   var cardCountBeforeClick = $('.category-list-section .food-detail-card').length;

//   console.log("cardCountBeforeClick", cardCountBeforeClick);

//   performActionsThatChangeCardCount(function() {
//       var cardCountAfterClick = $('.category-list-section .food-detail-card').length;
//       // Update class based on the new card count
//       if (cardCountAfterClick >= 0) {
//           $('.custom-section.category-section').addClass('swiper-container-mobile');
//       } else {
//           $('.custom-section.category-section').removeClass('swiper-container-mobile');
//       }
//   });
// });

// // Function that performs actions and accepts a callback to be executed after completion
// function performActionsThatChangeCardCount(callback) {
//   setTimeout(function() {
//       callback();
//   }, 100); // Adjust the timeout as needed
// }




// $(document).ready(function() {
//   var $stickyDiv = $('.swiper-container-mobile');
//   var stickyDivTop = $stickyDiv.offset().top;
//   var stickyClass = 'mobile-slider-sticky';

//   $(window).scroll(function() {
//       var scrollTop = $(window).scrollTop();

//       if (scrollTop >= stickyDivTop) {
//           $stickyDiv.addClass(stickyClass).css({
//               position: 'sticky',
//               top: 58,
//               zIndex: 9999,
//               // width: $stickyDiv.parent().width()
//           });
//       } else {
//           $stickyDiv.removeClass(stickyClass).css({
//               position: 'relative',
//               top: 'auto',
//               width: 'auto'
//           });
//       }
//   });

//   $(window).resize(function() {
//       $stickyDiv.css('width', $stickyDiv.parent().width());
//   });
// });


$(document).ready(function () {
  $(window).scroll(function () {
    var scrollPosition = $(window).scrollTop();
    var swiperOffset = $('.swiper-container-mobile').offset().top;

    if (scrollPosition >= (swiperOffset - 60)) {
      $('.swiper-container-mobile').addClass('sticky');
      // $('body').css('padding-top', 150);
    } else {
      $('.swiper-container-mobile').removeClass('sticky');
      // $('body').css('padding-top', 0);
    }
  });

});
