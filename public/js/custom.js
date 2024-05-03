$(document).ready(function(){
    $("#mobilesearchToggle").click(function(){
      $(".searcheaderBox").toggleClass("toggled");
    });

    $("#closeSearch").click(function(){
        $(".searcheaderBox").removeClass("toggled");
      });
  });