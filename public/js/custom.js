$(document).ready(function(){
    $("#mobilesearchToggle").click(function(){
      $(".searcheaderBox").toggleClass("toggled");
    });

    $("#closeSearch").click(function(){
        $(".searcheaderBox").removeClass("toggled");
      });

      $(window).bind('scroll', function () {
        var topNav = $(".menu-sidebar").height() + 10;
        if ($(window).scrollTop() > topNav) {
          $('.menu-sidebar').addClass('sticky');
        } else {
          $('.menu-sidebar').removeClass('sticky');
        }
      });
  });