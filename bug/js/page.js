$(document).ready(function() {
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
  /* ################## FILE CHANGE #################### */
  /* ################################################### */

  /*var fileBase64 = null;

  var handleFileSelect = function(evt) {
    var files = evt.target.files;
    var fileArray = new Array();

    $.map(files, function (val) {
      if (files) {
        var reader = new FileReader();

        reader.onload = function(readerEvt) {
          var binaryString = readerEvt.target.result;
          fileArray.push(btoa(binaryString));
        };

        reader.readAsBinaryString(val);
      }
    });

    fileBase64 = fileArray;
  };

  if (window.File && window.FileReader && window.FileList && window.Blob) {
    document.getElementById('file').addEventListener('change', handleFileSelect, false);
  } else {
    alert('[Error] Dein Browser ünterstützt das Dateien hochladen nicht.');
  }*/

  /* ################################################### */
  /* ################## FORM VALIDATION ################ */
  /* ################################################### */

  $('#bug_form').submit(function(event) {
    fire_ajax(1);
  });

  $('.floating-button').click(function(event) {
    fire_ajax(1);
  });

  $('.content .bug_form form .text-field input').each(function() {
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

  $('.content .bug_form form .text-field textarea').each(function() {
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
    var URL = $('#url').val();
    var MESSAGE = $('#msg').val();
    MESSAGE = MESSAGE.replace(/\n|\r/g, "\n");
    // var fileArray = $('#file').prop("files");
    // var FILENAMES = [ ];
    // $.map(fileArray, function(val) { FILENAMES.push(val.name); })
    // var FILES = fileBase64;

    $.post('system/transmission.php', {
      first_name: FIRST_NAME,
      last_name: LAST_NAME,
      email: EMAIL,
      url: URL,
      message: MESSAGE,
      // filenames: FILENAMES,
      // files: FILES,
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
              $('#url ~ .error').html(ERROR);
              $('#url')
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
            // if(entry.charAt(0) === '5') {
            //   var ERROR = entry.substr(2);
            //   $('#file ~ .error').html(ERROR);
            //   $('#file')
            //   .addClass('is-invalid')
            //   .parent().addClass('is-invalid');
            // }
          });
        });
        IS_VALIDATED = true;
      }
    });
  }
});
