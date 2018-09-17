$(document).ready(function() {

  $('div#recovery form .input-group .text-field').each(function(){
    changeState($(this));
  });

  $('div#recovery form .input-group .text-field').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    } else {
      $formControl.removeClass('has-value');
    }
  }


  $('div#recovery form .input-group .text-field').focusout(function(event) {
    if(IS_VALIDATED === true) {
      validate_form(0);
    }
  });

  $('div#recovery form').submit(function(event) {
    validate_form(1);
    IS_VALIDATED = true;
  });

  var IS_VALIDATED = false;

  function validate_form(ENTER) {
    var MODE = getURLParameter('mode');

    if(MODE == 'email') {
      var FIRST_NAME = $('#first_name').val();
      var LAST_NAME = $('#last_name').val();

      $.post('process_recover.php?mode=email', {
        first_name: FIRST_NAME,
        last_name: LAST_NAME,
        enter: ENTER
      }, function(data) {
        if(data.startsWith('>')) {
          var EMAIL = data.replace('>', '');
          window.location.replace('/index.php?popup=email-recover&success=true&email=' + EMAIL);
        } else if(data == 'FAILURE') {
          window.location.replace('/index.php?popup=email-recover&success=false');
        } else if(data != null) {

          $('.input-group input').each(function(index) {
            $(this).removeClass('is-invalid');
          });

          $('.input-group .error').each(function(index) {
            $(this).text('');
          });

          var ERRORS = data.split(';');

          ERRORS.forEach(function(item, index) {
            var PARTS = item.split('|');
            var ID = PARTS[0];
            var ERROR = PARTS[1];

            if(ID == '0') {
              $('#first_name ~ .error').text(ERROR);
              $('#first_name').addClass('is-invalid');
              if(ENTER == 1) {
                $('#first_name ~ .text-label').addClass('animated shake');
                $('#first_name ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#first_name ~ .text-label').removeClass('animated shake');
                });
              }
            } else if(ID == '1') {
              $('#last_name ~ .error').text(ERROR);
              $('#last_name').addClass('is-invalid');
              if(ENTER == 1) {
                $('#last_name ~ .text-label').addClass('animated shake');
                $('#last_name ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#last_name ~ .text-label').removeClass('animated shake');
                });
              }
            } else if(ID == '2') {
              $('#first_name ~ .error').text(ERROR);
              $('#first_name').addClass('is-invalid');
              $('#last_name ~ .error').text(ERROR);
              $('#last_name').addClass('is-invalid');
              if(ENTER == 1) {
                $('#first_name ~ .text-label').addClass('animated shake');
                $('#first_name ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#first_name ~ .text-label').removeClass('animated shake');
                });
                $('#last_name ~ .text-label').addClass('animated shake');
                $('#last_name ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#last_name ~ .text-label').removeClass('animated shake');
                });
              }
            }

          });

        } else {
          $('.input-group input').forEach(function(item, index) {
            $(this).removeClass('is-invalid');
          });

          $('.input-group .error').forEach(function(item, index) {
            $(this).text('');
          });
        }
      });
    } else if(MODE == 'password') {
      var EMAIL = $('#email').val();

      $.post('process_recover.php?mode=password', {
        email: EMAIL,
        enter: ENTER
      }, function(data) {
        if(data == 'SUCCESS') {
          var EMAIL_PARTS = EMAIL.split('@');
          var EMAIL_HOST = "";
          EMAIL_PARTS.forEach(function(element, index, array) {
            EMAIL_HOST = element;
          });
          window.location.replace('/index.php?popup=password-recover&success=true&mail=' + EMAIL_HOST);
        } else if(data == 'FAILURE') {
          window.location.replace('/index.php?popup=password-recover&success=false');
        } else if(data != null) {
          $('.input-group input').each(function(index) {
            $(this).removeClass('is-invalid');
          });

          $('.input-group .error').each(function(index) {
            $(this).text('');
          });

          $('#email ~ .error').text(data);
          $('#email').addClass('is-invalid');
          if(ENTER == 1) {
            $('#email ~ .text-label').addClass('animated shake');
            $('#email ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
              $('#email ~ .text-label').removeClass('animated shake');
            });
          }

        } else {
          $('.input-group input').each(function(index) {
            $(this).removeClass('is-invalid');
          });

          $('.input-group .error').each(function(index) {
            $(this).text('');
          });
        }
      });
    }
  }

  function getURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
      var sParameterName = sURLVariables[i].split('=');
      if (sParameterName[0] == sParam) {
        return decodeURIComponent(sParameterName[1]);
      }
    }
  }
});
