function imgReady() {
  $('#content .image img').css('opacity', '1');
  $('#content .image .loader').css('opacity', '0');
  setTimeout(function() {
    $('#content .image .loader').css('display', 'none');
  }, 110);
};
