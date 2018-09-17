$(document).ready(function() {
  optimizeView();
  $(window).on('orientationchange', function(event) {
    optimizeView();
  });

  function optimizeView() {
    $('#content').css('min-height', (($(window).width() >= 1300) ? ($(window).height() - 85 - 120) : ($(window).height() - 85)) + 'px');
    $('footer').css('position', (($(window).width() >= 1300) ? 'fixed' : 'static'));
    $('#content .steps').css('position', 'absolute');
  }

  /* RIPPLE OUT */

  setTimeout(function() {
    var ripple = $('#content .ripple');
    ripple.css('opacity', '0');
    setTimeout(function() {
      ripple.css('display', 'none');
    }, 600);
  }, 400);

  /* TEXT FIELD */

  $('#content .remark-field .text-field').each(function(){
    changeState($(this));
  });

  $('#content .remark-field .text-field').focusout(function() {
    changeState($(this));
  });

  function changeState($formControl){
    if($formControl.val().length > 0){
      $formControl.addClass('has-value');
    } else {
      $formControl.removeClass('has-value');
    }
  }

  /* RATING */

  $('#content .questionrating .rating img').click(function(event) {
    $(this).siblings().attr('src', '../../img/unfilled_star.svg');
    $(this).attr('src', '../../img/filled_star.svg');
    $(this).prev().attr('src', '../../img/filled_star.svg');
    $(this).prev().prev().attr('src', '../../img/filled_star.svg');
    $(this).prev().prev().prev().attr('src', '../../img/filled_star.svg');
    $(this).prev().prev().prev().prev().attr('src', '../../img/filled_star.svg');
    if($(this).hasClass('p1')) {
      $('#content .questionrating .rating-meaning p').text('Richtig schlecht');
    } else if($(this).hasClass('p2')) {
      $('#content .questionrating .rating-meaning p').text('Nicht so gut');
    } else if($(this).hasClass('p3')) {
      $('#content .questionrating .rating-meaning p').text('Mittelmäßig');
    } else if($(this).hasClass('p4')) {
      $('#content .questionrating .rating-meaning p').text('Gut');
    } else if($(this).hasClass('p5')) {
      $('#content .questionrating .rating-meaning p').text('Exzellent');
    }
  });

});
