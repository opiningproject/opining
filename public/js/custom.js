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
  // $(window).scroll(function () {
  //   $('.swiper-container-mobile').addClass('sticky');
  //   var scrollPosition = $(window).scrollTop();
  //   var swiperOffset = $('.category-section').offset().top;
  //   var categoryListOffset = $('.category-list-section').offset().top - 120;

  //   // if (scrollPosition >= swiperOffset) {
  //   //   $('.swiper-container-mobile').addClass('sticky');
  //   // } 

  //   if (scrollPosition < categoryListOffset) {
  //     $('.swiper-container-mobile').removeClass('sticky');
  //   }
  // });


});
// $(document).ready(function() {
//   var lastScrollTop = 0;

//   $(window).on('scroll', function() {
//       var footerOffset = $('#footer-style').offset().top;
//       var scrollPosition = $(window).scrollTop() + $(window).height();
//       var scrollTop = $(this).scrollTop();

//       // Remove sticky-active if scrolling up from bottom by 100px
//       if (scrollTop + $(window).height() < $(document).height() - 100) {
//           $('.swiper-container-mobile').removeClass('sticky-active');
//       } else if (scrollPosition >= footerOffset - 120) {
//           $('.swiper-container-mobile').addClass('sticky-active');
//       } else {
//           $('.swiper-container-mobile').removeClass('sticky-active');
//       }

//       lastScrollTop = scrollTop;
//   });
// });



var bannerSwiper = '';
$(document).ready(function () {

  bannerSwiper = new Swiper(".banner-swiper-slider", {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    autoplay: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
      bulletClass: 'swiper-pagination-bullet',
      bulletActiveClass: 'swiper-pagination-bullet-active',
      renderBullet: function (index, className) {
        return `<span class="${className}"></span>`;
      },
    },

  });
});

$(document).ready(function () {
  $('#sidebar-toggle-btn').on('click', function () {
    $('body').toggleClass('sidebar-toggle-body');
  });

  $('#sidebar-toggle-back').on('click', function () {
    $('body').removeClass('sidebar-toggle-body');
  });


});

$(document).ready(function () {
  // Show dropdown on focus or click
  $('#createCustomerInput').on('focus click', function () {
    $('#createCustomerDropdown').show();
  });

  // Hide dropdown when clicking outside
  $(document).on('click', function (e) {
    if (!$(e.target).closest('.form-group').length) {
      $('#createCustomerDropdown').hide();
    }
  });

  // Prevent dropdown closing when clicking inside it
  $('#createCustomerDropdown').on('click', function (e) {
    e.stopPropagation();
  });
});


// Mobile cart dropdown script

$(document).ready(function () {
  $('#head-dropdown-btn').on('click', function () {
    $('.address-select-modal-mobile, .top-head-dropdown, .cartSidebarCustom').toggleClass('active');
    $('.menu-sidebar').toggleClass('address-active');
    $('body').toggleClass('overflow-hidden');
  });

  // Prevent the click event from closing when clicking inside the modal
  $('.address-select-modal-mobile, .cart-sidebar-mobile').on('click', function (e) {
    e.stopPropagation();
  });

  // Remove 'active' class when clicking outside the modal or cart sidebar
  $(document).on('click', function (e) {
    if (!$(e.target).closest('.address-select-modal-mobile, .cart-sidebar-mobile, #head-dropdown-btn').length) {
      $('.address-select-modal-mobile, .top-head-dropdown, .cartSidebarCustom, .cart-sidebar-mobile').removeClass('active');
      $('.menu-sidebar').removeClass('active');
      $('body').removeClass('overflow-hidden');
    }
  });
});
