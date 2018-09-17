$(document).ready(function() {
  var FONT_TOO_BIG = true;
  function make_email_font_correct() {
    if($('div#content div#profile .extra-info .data .email').outerWidth() >= (0.48 * $(window).width())) {

      var SIZE = $('div#content div#profile .extra-info .data .email').css('font-size');
      SIZE = SIZE.substring(0, SIZE.length-2);
      SIZE = Number(SIZE) - 1;
      $('div#content div#profile .extra-info .data .email').css('font-size', SIZE.toString() + "px");

      setTimeout(function() {
        make_email_font_correct();
      }, 5);
    } else {
      FONT_TOO_BIG = false;
    }
  }

  function updateOnlineStatus() {
    $.ajax({
      url: './ajax/online_rl.php',
      type: 'POST',
      data: {user_id: PROFILE_USER_ID},
      success: function(data) {
        if(data == "ON") {
          $('div#content div#profile .basic-info .pic .online').removeClass('off');
        } else {
          $('div#content div#profile .basic-info .pic .online').addClass('off');
        }
      }
    });


    setTimeout(function() {
      updateOnlineStatus();
    }, 5000);
  }

  updateOnlineStatus();

  make_email_font_correct();
  $(window).resize(function(event) {
    make_email_font_correct();
  });
});
