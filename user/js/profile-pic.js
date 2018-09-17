$(document).ready(function() {
  $('div#content div#profile .basic-info .pic .online img').click(function(event) {
    $('div#content div.profile-pic-options').css("display", "block");
    $('div#content div.profile-pic-options-overlay').css("display", "block");
    setTimeout(function() {
      $('div#content div.profile-pic-options').css("bottom", "0");
      $('div#content div.profile-pic-options-overlay').css("opacity", "1");
    }, 5);
  });

  $('div#content div.profile-pic-options-overlay').click(function(event) {
    $('div#content div.profile-pic-options').css("bottom", "-400px");
    $('div#content div.profile-pic-options-overlay').css("opacity", "0");
    $('div#content input.file_input').each(function(index, el) {
      $(this).remove();
    });
    setTimeout(function() {
      $('div#content div.profile-pic-options').css("display", "none");
      $('div#content div.profile-pic-options-overlay').css("display", "none");
    }, 300);
  });

  $('div#content div.profile-pic-options div.action-set.upload').click(function(event) {
    $('div#content').append('<input type="file" id="profile-pic-file-picker" accept="image/*" name="Profilbild" />');
    $('div#content input#profile-pic-file-picker'). css({
      'opacity': '0',
      'position': 'absolute',
      'bottom': '-500px'
    });
    $('div#content div.profile-pic-options').css("bottom", "-400px");
    setTimeout(function() {
      $('div#content div.profile-pic-options').css("display", "none");
      $('#profile-pic-file-picker').trigger('click');
    }, 300);
  });

  $(document).on('change', '#profile-pic-file-picker', function() {
    alert("Hello! I am an alert box!!");
  });

});
