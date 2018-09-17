$(document).ready(function() {
  $('div#settings form .input-group .text-field').each(function(){
    changeState($(this));
  });

  $('div#settings form .input-group .text-field').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    } else {
      $formControl.removeClass('has-value');
    }
  }

  $('div#settings form .input-group .text-field').each(function() {
    $(this).focusout(function(event) {
      validate_field($(this).attr('id'), 0);
    });
  });

  $('div#settings form').submit(function(event) {
    validate_form();
  });

  function validate_field(FIELD, ENTER) {
    var VALUE = $('#' + FIELD).val();
    var SUCCESS = false;

    $.post('process_settings.php?action=validate_field', {
      field: FIELD,
      value: VALUE
    }, function(data) {
      if(data == "NONE") {
        $('#' + FIELD + ' ~ .error').text("");
        $('#' + FIELD).removeClass('is-invalid');
        SUCCESS = true;
      } else {
        $('#' + FIELD + ' ~ .error').text(data);
        $('#' + FIELD).addClass('is-invalid');
        SUCCESS = false;
        if(ENTER == 1) {
          $('#' + FIELD + ' ~ .text-label').addClass('animated shake');
          $('#' + FIELD + ' ~ .text-label').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
            $('#' + FIELD + ' ~ .text-label').removeClass('animated shake');
          });
        }
      }
    });
    return SUCCESS;
  }

  function validate_form() {
    var FIRST_NAME = $('#first_name').val();
    var LAST_NAME = $('#last_name').val();
    var EMAIL = $('#email').val();
    var CLASS = $('#class').val();
    var GENDER = $('#gender').val();

    $.post('process_settings.php', {
      first_name: FIRST_NAME,
      last_name: LAST_NAME,
      email: EMAIL,
      class: CLASS,
      gender: GENDER
    }, function(data) {
      if(data == "SUCCESS") {
        window.location.replace("/index.php?popup=settings&success=true");
      } else if(data == "FAILURE") {
        window.location.replace("/index.php?popup=settings&success=false");
      } else if(data == "NOT_VALID") {
        validate_field('first_name', 1);
        validate_field('last_name', 1);
        validate_field('email', 1);
        validate_field('class', 1);
      }
    });
  }
});
