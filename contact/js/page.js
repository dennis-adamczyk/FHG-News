$(document).ready(function() {

  /* ################################################### */
  /* ################ PARALLAX ######################### */
  /* ################################################### */

  var $parallaxBox = $('.content .top .bg');
  var $parallaxParent = $('.content .top');

  function animateParallax() {
    $scrollTop = $(window).scrollTop();
    $width = $(window).width();
    if(($width < 800 && $scrollTop <= 112) || ($width >= 800 && $scrollTop <= 192)) {
      $parallaxBox.css('transform', 'translateY(' + ($scrollTop * 0.4) + 'px)');
    }
    window.requestAnimationFrame(animateParallax);
  }

  window.requestAnimationFrame(animateParallax);

  /* ################################################### */
  /* ################## TEXT FIELDS #################### */
  /* ################################################### */

  $('.text-field_input').each(function() {
    changeState($(this));
  });

  $('.text-field_input').focusout(function(event) {
    changeState($(this));
  });

  function changeState($textfield) {
    if($textfield.val().length > 0) {
      $textfield.addClass('has-value');
    } else {
      $textfield.removeClass('has-value')
    }
  }

  /* ################################################### */
  /* ################## RIPPLE ######################### */
  /* ################################################### */

  Waves.attach('.content div.floating-button', ['waves-circle', 'waves-float', 'waves-light']);

  /* ################################################### */
  /* ################## FORM VALIDATION ################ */
  /* ################################################### */

  $('#contact_form').submit(function(event) {
    fire_ajax(1);
  });

  $('.floating-button').click(function(event) {
    fire_ajax(1);
  });

  $('.content .contact-form form .text-field input').each(function() {
    $(this).keyup(function(event) {
      if(event.keyCode == 13) {
        fire_ajax(1);
      } else {
        if(IS_VALIDATED) {
          fire_ajax(0);
        }
      }
    });
  });

  $('.content .contact-form form .text-field textarea').each(function() {
    $(this).keyup(function(event) {
      if(IS_VALIDATED) {
        fire_ajax(0);
      }
    });
  });


  var IS_VALIDATED = false;

  function fire_ajax(ENTER) {
    var FIRST_NAME = $('#first-name').val();
    var LAST_NAME = $('#last-name').val();
    var EMAIL = $('#email').val();
    var SUBJECT = $('#subject').val();
    var MESSAGE = $('#msg').val();
    MESSAGE = MESSAGE.replace(/\n|\r/g, "\n");

    $.post('system/transmission.php', {
      first_name: FIRST_NAME,
      last_name: LAST_NAME,
      email: EMAIL,
      subject: SUBJECT,
      message: MESSAGE,
      enter: ENTER
    }, function(data) {
      console.log(data);
      if(data == "SUCCESS") {
        window.location.replace("?success");
      } else if(data == "FAILURE") {
        window.location.replace("?failure");
      } else if(data == " ") {
        $('.text-field input').each(function() {
          $(this).removeClass('is-invalid')
          .parent().removeClass('is-invalid');
        });
        $('.text-field textarea').each(function() {
          $(this).removeClass('is-invalid')
          .parent().removeClass('is-invalid');
        });
        $('.text-field .error').each(function() {
          $(this).text("");
        });
      } else {
        var datas = data.split(";");
        $('.text-field input').each(function() {
          $(this).removeClass('is-invalid')
          .parent().removeClass('is-invalid');
        });
        $('.text-field textarea').each(function() {
          $(this).removeClass('is-invalid')
          .parent().removeClass('is-invalid');
        });
        $('.error').each(function() {
          $(this).text("");
          datas.forEach(function(entry) {
            if(entry.charAt(0) === '0') {
              var ERROR = entry.substr(2);
              $('#first-name ~ .error').html(ERROR);
              $('#first-name')
                .addClass('is-invalid')
                .parent().addClass('is-invalid');
            }
            if(entry.charAt(0) === '1') {
              var ERROR = entry.substr(2);
              $('#last-name ~ .error').html(ERROR);
              $('#last-name')
                .addClass('is-invalid')
                .parent().addClass('is-invalid');
            }
            if(entry.charAt(0) === '2') {
              var ERROR = entry.substr(2);
              $('#email ~ .error').html(ERROR);
              $('#email')
              .addClass('is-invalid')
              .parent().addClass('is-invalid');
            }
            if(entry.charAt(0) === '3') {
              var ERROR = entry.substr(2);
              $('#subject ~ .error').html(ERROR);
              $('#subject')
              .addClass('is-invalid')
              .parent().addClass('is-invalid');
            }
            if(entry.charAt(0) === '4') {
              var ERROR = entry.substr(2);
              $('#msg ~ .error').html(ERROR);
              $('#msg')
              .addClass('is-invalid')
              .parent().addClass('is-invalid');
            }
          });
        });
        IS_VALIDATED = true;
      }
    });
  }

});
