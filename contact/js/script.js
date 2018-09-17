$(document).ready(function() {
  $('#content form .input-group .text-field').each(function(){
    changeState($(this));
  });

  $('#content form .input-group .text-field').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    } else {
      $formControl.removeClass('has-value');
    }
  }

  $('#content form').submit(function(event) {
    fire_ajax(1);
  });

  $('#content form .input-group input').each(function() {
    $(this).keyup(function(event) {
      if(IS_VALIDATED) {
        fire_ajax(0);
      }
    });
  });

  var IS_VALIDATED = false;

  function fire_ajax(ENTER) {
    var NAME = $('#name').val();
    var EMAIL = $('#email').val();
    var SUBJECT = $('#subject').val();
    var MESSAGE = $('#message').val();
    MESSAGE = MESSAGE.replace(/\n|\r/g, "\n");

    $.post('transmission.php', {
      name: NAME,
      email: EMAIL,
      subject: SUBJECT,
      message: MESSAGE,
      enter: ENTER
    }, function(data) {
      if(data == "SUCCESS") {
        window.location.replace("/index.php?popup=contact&success=true");
      } else if(data == "FAILURE") {
        window.location.replace("/index.php?popup=contact&success=false");
      } else if(data == " ") {
        $('.input-group input').each(function() {
          $(this).removeClass('is-invalid');
        });
        $('.input-group .error').each(function() {
          $(this).text("");
        });
      } else {
        var datas = data.split(";");
        $('.input-group input').each(function() {
          $(this).removeClass('is-invalid');
        });
        $('.error').each(function() {
          $(this).text("");
          datas.forEach(function(entry) {
            if(entry.charAt(0) === '0') {
              var ERROR = entry.substr(2);
              $('#name ~ .error').html(ERROR);
              $('#name').addClass('is-invalid');
            }
            if(entry.charAt(0) === '1') {
              var ERROR = entry.substr(2);
              $('#email ~ .error').html(ERROR);
              $('#email').addClass('is-invalid');
            }
            if(entry.charAt(0) === '2') {
              var ERROR = entry.substr(2);
              $('#subject ~ .error').html(ERROR);
              $('#subject').addClass('is-invalid');
            }
            if(entry.charAt(0) === '3') {
              var ERROR = entry.substr(2);
              $('#message ~ .error').html(ERROR);
              $('#message').addClass('is-invalid');
            }
          });
        });
        IS_VALIDATED = true;
      }
    });
  }

});
