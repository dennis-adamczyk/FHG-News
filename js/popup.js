$(document).ready(function() {
  $('#tick_path').addClass('checked');
  $('#cross_path1').addClass('checked');
  $('#cross_path2').addClass('checked');
  $('.popup #s-okay').click(function(event) {
    $('.popup').css('opacity', '0');
    $('.popup-overlay').css('opacity', '0');
    setTimeout(function(){
      var url = window.location.href;
      var urlParts = url.split('?');
      window.location.replace(urlParts[0]);
      $('.popup').css('display', 'none');
      $('.popup-overlay').css('display', 'none');
    }, 810);
  });
  $('.popup #f-okay').click(function(event) {
    $('.popup').css('opacity', '0');
    $('.popup-overlay').css('opacity', '0');
    setTimeout(function(){
      var url = window.location.href;
      var urlParts = url.split('?');
      window.location.replace(urlParts[0]);
      $('.popup').css('display', 'none');
      $('.popup-overlay').css('display', 'none');
    }, 800);
  });
});
