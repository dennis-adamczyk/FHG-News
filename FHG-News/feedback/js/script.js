$(document).ready(function() {
  optimizeView();
  $(window).resize(function(event) {
    optimizeView();
  });

  function optimizeView() {
    $('#content').css('min-height', (($(window).width() >= 1300) ? ($(window).height() - 85 - 120) : ($(window).height() - 85)) + 'px');
    $('footer').css('position', (($(window).width() >= 1300) ? 'fixed' : 'static'));
    if($('#content p.text:last-of-type').offset().top + $('#content p.text:last-of-type').outerHeight() >= $('#content .steps').offset().top) {
      $('#content .steps').css('position', 'relative');
    } else {
      $('#content .steps').css('position', 'absolute');
    }
  }

  /* RIPPLE CLICK */

  $('#content .steps').click(function(event) {
    var ripple = $('#content .ripple');
    var clientX = event.clientX;
    var clientY = event.clientY + $(document).scrollTop();
    ripple.css('left', clientX + 'px');
    ripple.css('top', clientY + 'px');
    ripple.css('width', '200v' + (($(window).width() > $(window).height()) ? 'w' : 'h'));
    ripple.css('height', '200v' + (($(window).width() > $(window).height()) ? 'w' : 'h'));
    setTimeout(function() {
      window.location.href = "questions/1/";
    }, 600)
  });
});
