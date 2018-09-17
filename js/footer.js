$(document).ready(function() {
  $(window).resize(function(event) {
    setfooterCorrect();
    $('footer').css('opacity', '1');
  });

  setfooterCorrect();
  $('footer').css('opacity', '1');

  function setfooterCorrect() {
    $('footer').css('position', 'static');
    if(window.innerHeight > ($('footer').offset().top + $('footer').outerHeight())) {
      $('footer').css('position', 'fixed');
    } else {
      $('footer').css('position', 'static');
    }
  }
});
