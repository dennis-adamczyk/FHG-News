$(document).ready(function() {
  $('header .header-notifications').addClass('logged_in');
  $('div.header-notifications-menu').addClass('logged_in');

  $('nav ul.list ul li.OrgaPlan').click(function(event) {
    window.location = '/editorial/OrgaPlan/';
  });

  // $('nav ul.list ul li.Meine_Artikel').click(function(event) {
  //   window.location = '/editorial/my_articles/';
  // });
});
