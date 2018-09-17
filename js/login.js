$(document).ready(function() {

  $('div#login').stop().click(function() {
    if($('.user_dropdown').css('display') == 'none') {
      $('div#login img').css('opacity', '0.7');
      $('.user_dropdown').fadeIn('fast');
    } else {
      $('div#login img').css('opacity', '0.5');
      $('.user_dropdown').fadeOut('fast');
    }
  });

  $('div#login-form #overlay').stop().click(function() {
    $('div#login img').css('opacity', '0.5');
    $('.user_dropdown').fadeOut('fast');
  });

  $('div#login img').hover(function() {
    if($('.user_dropdown').css('display') == 'none') {
      $(this).css('opacity', '0.6');
    }

  }, function() {
    if($('.user_dropdown').css('display') == 'none') {
      $(this).css('opacity', '0.5');
    } else {
      $(this).css('opacity', '0.7');
    }
  });


  var FONT_IS_TOO_BIG = true;
  function make_font_correct() {
    if($('div#user-menu #field #profile-preview .name').outerHeight() >= 21) {
      var SIZE = $('div#user-menu #field #profile-preview .name p').css('font-size');
      SIZE = SIZE.substring(0, SIZE.length-2);
      SIZE = Number(SIZE) - 1;
      $('div#user-menu #field #profile-preview .name p').css('font-size', SIZE.toString() + "px");

      setTimeout(function() {
        make_font_correct();
      }, 10);
    } else {
      FONT_IS_TOO_BIG = false;
    }
  }

  $('header div#profile').stop().click(function() {
    if($('.user_dropdown').css('display') == 'none') {
      $('div#profile img').css('opacity', '0.7');
      $('.user_dropdown').fadeIn('fast');

      make_font_correct();

    } else {
      $('header div#profile img').css('opacity', '0.5');
      $('.user_dropdown').fadeOut('fast');
    }
  });

  $('header div#profile img').hover(function() {
    $('header div#profile img').css('opacity', '0.6');
  }, function() {
    if($('.user_dropdown').css('display') == 'none') {
      $(this).css('opacity', '0.5');
    } else {
      $(this).css('opacity', '0.7');
    }
  });

  $('header #overlay').stop().click(function() {
    $('div#profile img').css('opacity', '0.5');
    $('.user_dropdown').fadeOut('fast');
  });

  $('header #field #profile-preview').click(function(event) {
    window.location.replace("/user/" + USER_PROFILE_NAME);
  });



  $('div#login-form #field form .input-group .form-control').each(function(){
    changeState($(this));
  });

  $('div#login-form #field form .input-group .form-control').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    }
    else{
      $formControl.removeClass('has-value');
    }
  }


  $('div#login-form #field form#form-login').submit(function(event) {
    ajax_perform(1);
  });

  $('div#login-form #field form#form-login .input-group input').focusout(function(event) {
    if(IS_VALIDATED === true) {
      ajax_perform(0);
    }
  });


  /* AJAX PHP */

  var IS_VALIDATED = false;

  function ajax_perform(ENTER) {

    var EMAIL = $('#login-form-email').val();
    var PASSWORD = $('#login-form-password').val();
    var REMEMBER_ME = Number($("#field #form-login .input-group .remember-me input[type=checkbox]").is(":checked"));

    $.post('/login/login.php', {
      email: EMAIL,
      password: PASSWORD,
      remember: REMEMBER_ME,
      enter: ENTER
    }, function(data) {
      IS_VALIDATED = true;
      $('form#form-login .input-group .error').each(function(index, el) {
        $(this).html('');
      });
      $('form#form-login .input-group input').each(function(index, el) {
        $(this).removeClass('is-invalid');
      })
      if(data === "SUCCESS") {
        location.reload();
      } else if(data == null || data === undefined) {

      } else {
        var ERRORS = data.split(';');

        ERRORS.forEach(function(element, index, array) {
          var PARTS = element.split('|');
          var NUM = PARTS[0];
          var ERROR = PARTS[1];

          if(NUM == '0') {
            $('form#form-login .input-group #login-form-email').addClass('is-invalid');
            $('form#form-login .input-group #login-form-email ~ .error').html(ERROR);
            if(ENTER == 1) {
              $('form#form-login .input-group #login-form-email ~ .form-text-label').addClass('animated shake');
              $('form#form-login .input-group #login-form-email ~ .form-text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $('form#form-login .input-group #login-form-email ~ .form-text-label').removeClass('animated shake');
              });
            }
          } else if(NUM == '1') {
            $('form#form-login .input-group #login-form-password').addClass('is-invalid');
            $('form#form-login .input-group #login-form-password ~ .error').html(ERROR);
            if(ENTER == 1) {
              $('form#form-login .input-group #login-form-password ~ .form-text-label').addClass('animated shake');
              $('form#form-login .input-group #login-form-password ~ .form-text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $('form#form-login .input-group #login-form-password ~ .form-text-label').removeClass('animated shake');
              });
            }
          }

        });
      }
    })
      .fail(function(){
        window.location.replace('/index.php?popup=login&success=false');
      });
  }
});
