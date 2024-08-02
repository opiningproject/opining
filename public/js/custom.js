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