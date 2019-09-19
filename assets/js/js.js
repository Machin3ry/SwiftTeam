$( document ).ready(function() {
  $(".log-in").click(function(){
  $(".signIn").addClass("active-dx");
  $(".signUp").addClass("inactive-sx");
  $(".signUp").removeClass("active-sx");
  $(".signIn").removeClass("inactive-dx");
});
$(".back").click(function(){
  $(".signUp").addClass("active-sx");
  $(".signIn").addClass("inactive-dx");
  $(".signIn").removeClass("active-dx");
  $(".signUp").removeClass("inactive-sx");
});
$(function(){
  $(".facebook").mouseover(function(){
    $(".fa-facebook").css("color" , "#ef3f5b");
    $(".facebook").css("background" , "white");
  });
});
$(function(){
  $(".facebook").mouseout(function(){
    $(".fa-facebook").css("color" , "white");
    $(".facebook").css("background" , "transparent");
  });
});
$(function(){
  $(".twitter").mouseover(function(){
    $(".fa-twitter").css("color" , "#ef3f5b");
    $(".twitter").css("background" , "white");
  });
});
$(function(){
  $(".twitter").mouseout(function(){
    $(".fa-twitter").css("color" , "white");
    $(".twitter").css("background" , "transparent");
  });
});
$(function(){
  $(".linkedin").mouseover(function(){
    $(".fa-linkedin").css("color" , "#ef3f5b");
    $(".linkedin").css("background" , "white");
  });
});
$(function(){
  $(".linkedin").mouseout(function(){
    $(".fa-linkedin").css("color" , "white");
    $(".linkedin").css("background" , "transparent");
  });
});

$(function(){
  
  $( "#login" ).click(function(){
    $("#login-form" ).show();
    $( "#signup-form" ).hide();
  });
});

$(function(){
    $("#signup-form").hide();
    $( "#signup" ).click(function(){
      $( "#signup-form" ).show();
      $("#login-form" ).hide();
    });
  });
});