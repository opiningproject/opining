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
  // Function to handle sticky behavior
  function initStickySwiper() {
      var $swiperContainer = $('.swiper-container-mobile');
      var $productContainer = $('.category-list-section');
      
      // Ensure the swiper container exists in the DOM
      if ($swiperContainer.length > 0) {
          // If the container does not exist, add it to the DOM (optional)
          // This can be a fallback placeholder if you want the sticky behavior regardless
          $('body').prepend('<div class="swiper-container-mobile"></div>');
          $swiperContainer = $('.swiper-container-mobile');
      }

      // Get the initial offset of the container
      var stickyOffset = $productContainer.offset().top - 150;

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


$(document).on('click', '.category-slider .category-element', function() {
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


