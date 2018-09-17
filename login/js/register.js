$(document).ready(function() {

  $('div#register form .input-group .text-field').each(function(){
    changeState($(this));
  });

  $('div#register form .input-group .text-field').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    } else {
      $formControl.removeClass('has-value');
    }
  }

  $('div#register form .input-group select').change(function(event) {
    if($('div#register form .input-group select').val() != "") {
      $('div#register form .input-group select').css('color', '#000');
    } else {
      $('div#register form .input-group select').css('color', '#757575');
    }
  });

  var safety = 0;
  $('#password1').on('keyup focusin', function(event) {
    var text = $(this).val();
    if(text.length >= 8) {
      safety++;
    }
    if(text.match(/[A-Zä-ü]/) !== null) {
      safety++;
    }
    if(text.match(/[a-zß-ü]/) !== null) {
      safety++;
    }
    if(text.match(/[0-9]/) !== null) {
      safety++;
    }
    if(text.match(/\W/) !== null) {
      safety++;
    }

    if(safety == 0) {
      $(this).css('border-color', '#c0392b');
      $('#safety-text').css('color', '#c0392b');
      $('#safety-text').text("Ungenügend");
    } else if(safety == 1) {
      $(this).css('border-color', '#e74c3c');
      $('#safety-text').css('color', '#e74c3c');
      $('#safety-text').text("Mangelhaft");
    } else if(safety == 2) {
      $(this).css('border-color', '#e67e22');
      $('#safety-text').css('color', '#e67e22');
      $('#safety-text').text("Ausrechend");
    } else if(safety == 3) {
      $(this).css('border-color', '#f1c40f');
      $('#safety-text').css('color', '#f1c40f');
      $('#safety-text').text("Befriedigend");
    } else if(safety == 4) {
      $(this).css('border-color', '#2ecc71');
      $('#safety-text').css('color', '#2ecc71');
      $('#safety-text').text("Gut");
    } else if(safety == 5) {
      $(this).css('border-color', '#3498db');
      $('#safety-text').css('color', '#3498db');
      $('#safety-text').text("Sehr gut");
    }
  });


  $('div#register form').submit(function(event) {
    fire_ajax(1);
  });

  $('div#register form .input-group input').each(function() {
    $(this).keyup(function(event) {
      if(IS_VALIDATED) {
        fire_ajax(0);
      }
    });
  });

  $('div#register form .input-group select').each(function() {
    $(this).change(function(event) {
      if(IS_VALIDATED) {
        fire_ajax(0);
      }
    });
  });

  var IS_VALIDATED = false;

  function fire_ajax(ENTER) {
    $('.spinner').css('display', 'block');

    var FIRST_NAME = $('#first_name').val();
    var LAST_NAME = $('#last_name').val();
    var EMAIL = $('#email').val();
    var CLASS = $('#class').val();
    var GENDER = $('#gender').val();
    var PASSWORD1 = $('#password1').val();
    var PASSWORD2 = $('#password2').val();
    var G_RECAPTCHA_RESPONSE = grecaptcha.getResponse();

    $.post('process_register.php', {
      first_name: FIRST_NAME,
      last_name: LAST_NAME,
      email: EMAIL,
      class: CLASS,
      gender: GENDER,
      password1: PASSWORD1,
      password2: PASSWORD2,
      g_recaptcha_response: G_RECAPTCHA_RESPONSE,
      safe: safety
    }, function(data) {
      if(data.startsWith('SUCCESS|')) {
        if(ENTER == 1) {
          var PARTS = data.split('|');
          var MAIL = PARTS[1];
          window.location.replace("/index.php?popup=register&success=true&mail=" + MAIL);
        }
      } else if(data == 'FAILURE') {
        window.location.replace("/index.php?popup=register&success=false");
      } else {
        var datas = data.split(";");
        $('.input-group input').each(function() {
          $(this).removeClass('is-invalid');
        });
        $('.input-group select').each(function() {
          $(this).removeClass('is-invalid');
        });
        $('.error').each(function() {
          $(this).text("");
          datas.forEach(function(entry) {
            if(entry.charAt(0) === '0') {
              var ERROR = entry.substr(2);
              $('#first_name ~ .error').html(ERROR);
              $('#first_name').addClass('is-invalid');
              if(ENTER == 1) {
                $('#first_name ~ .text-label').addClass('animated shake');
                $('#first_name ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#first_name ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '1') {
              var ERROR = entry.substr(2);
              $('#last_name ~ .error').html(ERROR);
              $('#last_name').addClass('is-invalid');
              if(ENTER == 1) {
                $('#last_name ~ .text-label').addClass('animated shake');
                $('#last_name ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#last_name ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '2') {
              var ERROR = entry.substr(2);
              $('#email ~ .error').html(ERROR);
              $('#email').addClass('is-invalid');
              if(ENTER == 1) {
                $('#email ~ .text-label').addClass('animated shake');
                $('#email ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#email ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '3') {
              var ERROR = entry.substr(2);
              $('#class ~ .error').html(ERROR);
              $('#class').addClass('is-invalid');
              if(ENTER == 1) {
                $('#class ~ .text-label').addClass('animated shake');
                $('#class ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#class ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '4') {
              var ERROR = entry.substr(2);
              $('#gender ~ .error').html(ERROR);
              $('#gender').addClass('is-invalid');
              if(ENTER == 1) {
                $('#gender ~ .text-label').addClass('animated shake');
                $('#gender ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#gender ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '5') {
              var ERROR = entry.substr(2);
              $('#password1 ~ .error').html(ERROR);
              $('#password1').addClass('is-invalid');
              if(ENTER == 1) {
                $('#password1 ~ .text-label').addClass('animated shake');
                $('#password1 ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#password1 ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '6') {
              var ERROR = entry.substr(2);
              $('#password2 ~ .error').html(ERROR);
              $('#password2').addClass('is-invalid');
              if(ENTER == 1) {
                $('#password2 ~ .text-label').addClass('animated shake');
                $('#password2 ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#password2 ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '7') {
              var ERROR = entry.substr(2);
              $('.g-recaptcha ~ .error').html(ERROR);
              if(ENTER == 1) {
                $('.g-recaptcha ~ .text-label').addClass('animated shake');
                $('.g-recaptcha ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('.g-recaptcha ~ .text-label').removeClass('animated shake');
                });
              }
            }
          });
        });
        IS_VALIDATED = true;
      }
      $('.spinner').css('display', 'none');
    });
  }

});
