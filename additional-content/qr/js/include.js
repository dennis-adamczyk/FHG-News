$(document).ready(function() {
  $('.content .second_header .title').text(article_title);
  $('.content .second_header .close').click(function(event) {
    window.location = '/additional-content/';
  });

  Waves.attach('.content .second_header .close', ['waves-light']);
});
