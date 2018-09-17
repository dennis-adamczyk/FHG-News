$(document).ready(function() {

  /* ################################################### */
  /* ################## CSS STYLE ###################### */
  /* ################################################### */

  optimizeCSS();

  $(window).resize(function(event) {
    optimizeCSS();
  });

  function optimizeCSS() {
    $('.content div.login_form').css('top', (($(window).innerHeight()/2)-$('header').outerHeight()) + "px");
  }

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
  /* ################## RIPPLE EFFECT ################## */
  /* ################################################### */

  Waves.attach('.content div.login_form div.form #form div.submit input#submit', ['waves-button']);

  /* ################################################### */
  /* ################## FORM VALIDATION ################ */
  /* ################################################### */

  $('#form').submit(function(event) {
    fire_ajax(1);
  });

  $('#submit').click(function(event) {
    fire_ajax(1);
  });

  $('.content div.login_form div.form #form div.text-field input').each(function() {
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
    var USERNAME = $('#username').val();
    var PASSWORD = $('#password').val();
    var REMEMBER = ($('#remember').prop('checked') ? 1 : 0);

    $.post('system/login.php', {
      username: USERNAME,
      password: PASSWORD,
      remember: REMEMBER,
      enter: ENTER
    }, function(data) {
      console.log(data);
      if(data == "SUCCESS") {
        if(window.location.href.includes('?page=')) {
          parts = window.location.href.split('page=');
          window.location.replace(parts[1]);
        } else {
          window.location.replace("OrgaPlan/");
        }
      } else if(data == "ACTIVATE") {
        window.location.replace('change_password/');
      } else if(data == "FAILURE") {
        window.location.replace("?failure");
      } else if(data == " ") {
        $('.text-field input').each(function() {
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
        $('.error').each(function() {
          $(this).text("");
          datas.forEach(function(entry) {
            if(entry.charAt(0) === '0') {
              var ERROR = entry.substr(2);
              $('#username ~ .error').html(ERROR);
              $('#username')
                .addClass('is-invalid')
                .parent().addClass('is-invalid');
            }
            if(entry.charAt(0) === '1') {
              var ERROR = entry.substr(2);
              $('#password ~ .error').html(ERROR);
              $('#password')
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
