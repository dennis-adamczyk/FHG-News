$(document).ready(function() {

  if($(window).width() < 600) {
    optimizeYouTube();
  }

  $(window).resize(function(event) {
    if($(window).width() < 600) {
      optimizeYouTube();
    }
  });

  function optimizeYouTube() {
    var iframeWidth = $(window).width() * 0.9;
    $('#content iframe').css('width', iframeWidth + 'px');
    $('#content iframe').css('height', (iframeWidth * 9 / 16) + 'px');
  }

});
