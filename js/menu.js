$(document).ready(function(){

  $('#dropdown-icon').removeClass('rotate-180deg');
  $('#nav_FHG-News_ul').hide('1', function() {
    $('#nav_under_FHG-News').css('border-top', 'none');
  });

  var MENU_OPEN = false;

  $('.menu-icon').stop().click(function() {
    if(MENU_OPEN === false) {
      MENU_OPEN = true;
      $('.menu-icon').addClass('is-active');
      $('#sidebar').addClass('is-active');
    } else {
      MENU_OPEN = false;
      $('.menu-icon').removeClass('is-active');
      $('#sidebar').removeClass('is-active');
      setTimeout(function(){
        $('#dropdown-icon').removeClass('rotate-180deg');
        $('#nav_FHG-News_ul').hide('1', function() {
          $('#nav_under_FHG-News').css('border-top', 'none');
        });
      }, 400);
    }
  });
  $('#content').stop().click(function(event) {
    if(MENU_OPEN === true) {
      MENU_OPEN = false;
      $('.menu-icon').removeClass('is-active');
      $('#sidebar').removeClass('is-active');
      setTimeout(function(){
        $('#dropdown-icon').removeClass('rotate-180deg');
        $('#nav_FHG-News_ul').hide('1', function() {
          $('#nav_under_FHG-News').css('border-top', 'none');
        });
      }, 400);
    }
  });

  $('aside nav ul a').click(function(event) {
    MENU_OPEN = false;
    $('.menu-icon').removeClass('is-active');
    $('#sidebar').removeClass('is-active');
    setTimeout(function(){
      $('#dropdown-icon').removeClass('rotate-180deg');
      $('#nav_FHG-News_ul').hide('1', function() {
        $('#nav_under_FHG-News').css('border-top', 'none');
      });
    }, 400);
  });
});
