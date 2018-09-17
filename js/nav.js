$(document).ready(function() {
  if($('.menu-icon').css('display') === 'none') {
    var MOUSE_ON_DROPDOWN = false;
    var MOUSE_ON_POINT = false;

    $('#sidebar nav ul ul').hover(function() {
      MOUSE_ON_DROPDOWN = true;
    }, function() {
      MOUSE_ON_DROPDOWN = false;
      setTimeout(function(){
        if(MOUSE_ON_POINT === false) {
          $('#sidebar nav ul ul').css('opacity', '0');
          setTimeout(function(){
            $('#sidebar nav ul ul').css('display', 'none');
          }, 200);
        }
      }, 5);

    });

    $('#nav_FHG-News').stop().hover(function() {
      $('#nav_FHG-News_ul').show();
      MOUSE_ON_POINT = true;
      $('#sidebar nav ul ul').css('display', 'block');
      setTimeout(function(){
        $('#sidebar nav ul ul').css('opacity', '1');
      }, 5);
    }, function() {
      setTimeout(function(){
        MOUSE_ON_POINT = false;
        if(MOUSE_ON_DROPDOWN === false) {
          $('#sidebar nav ul ul').css('opacity', '0');
          setTimeout(function(){
          $('#sidebar nav ul ul').css('display', 'none');
        }, 200);
        }
      }, 5);
    });
  } else {
    $('#nav_FHG-News').stop().click(function(event) {
      $('#nav_under_FHG-News').css('border-top', '1px solid rgba(255, 255, 255, 0.2)');
      $('#dropdown-icon').toggleClass('rotate-180deg');
      $('#nav_FHG-News_ul').stop().slideToggle('slow', function() {
        $('#nav_under_FHG-News').css('border-top', 'none');
      });
    });
  }

  var LI_IS_CLICKED = false;

  $('#sidebar nav ul li').stop().click(function(event) {
    if(LI_IS_CLICKED === false) {
      if($(this).attr('id') != 'active') {
        LI_IS_CLICKED = true;
        $(this).addClass('li-clicked');
        setTimeout(function(){
          $.each($('.li-clicked'), function(){
            $(this).removeClass('li-clicked');
            LI_IS_CLICKED = false;
          });
        }, 300);
      }
    }
  });
});
