$(document).ready(function() {

  $('div#cpw form .input-group .text-field').each(function(){
    changeState($(this));
  });

  $('div#cpw form .input-group .text-field').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    } else {
      $formControl.removeClass('has-value');
    }
  }

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


  $('div#cpw form').submit(function(event) {
    fire_ajax(1);
  });

  $('div#cpw form .input-group input').each(function() {
    $(this).keyup(function(event) {
      if(IS_VALIDATED) {
        fire_ajax(0);
      }
    });
  });

  var IS_VALIDATED = false;

  function fire_ajax(ENTER) {
    var CURRENT_PASSWORD = $('#current_password').val();
    var PASSWORD1 = $('#password1').val();
    var PASSWORD2 = $('#password2').val();

    $.post('process_changepassword.php', {
      current_password: CURRENT_PASSWORD,
      password1: PASSWORD1,
      password2: PASSWORD2,
      enter: ENTER,
      safe: safety
    }, function(data) {
      if(data == "SUCCESS") {
        window.location.replace("/index.php?popup=changepassword&success=true");
      } else if(data == "FAILURE") {
        window.location.replace("/index.php?popup=changepassword&success=false");
      } else if(data == " ") {
        $('.input-group input').each(function() {
          $(this).removeClass('is-invalid');
        });
        $('.error').each(function() {
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
              $('#current_password ~ .error').html(ERROR);
              $('#current_password').addClass('is-invalid');
              if(ENTER == 1) {
                $('#current_password ~ .text-label').addClass('animated shake');
                $('#current_password ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                  $('#current_password ~ .text-label').removeClass('animated shake');
                });
              }
            }
            if(entry.charAt(0) === '1') {
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
            if(entry.charAt(0) === '2') {
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
          });
        });
        IS_VALIDATED = true;
      }
    });
  }

});
