$(document).ready(function() {

  cssOptimize();
  scrollAnimation();

  $(window).resize(function(event) {
    cssOptimize();
  });

  function cssOptimize() {
    $('section.sec1').css('height', ($(window).height()-$('header').outerHeight()) + "px");
    $('#go_content').css('top', ($('section.sec2').offset().top- 2 * $('header').outerHeight()) + 'px');
    $('.content section.sec6 div.sec-content div.slider div.images div.image').css('width', $('.content section.sec6 div.sec-content div.slider').outerWidth() + 'px');
    $('.content section.sec6 div.sec-content div.slider div.images div.image').each(function(index, el) {
      var i = 0;
      opti();
      function opti() {
        if($(el).offset().top > $('.content section.sec6 div.sec-content div.slider').offset().top) {
          $(el).css('top', (parseInt($(el).css('top'))-1) + 'px');
          i++;
          setTimeout(function() {
            if(i < 1000) {opti();}
          }, 5);
        } else if($(el).offset().top < $('.content section.sec6 div.sec-content div.slider').offset().top) {
          $(el).css('top', (parseInt($(el).css('top'))+1) + 'px');
          i++;
          setTimeout(function() {
            if(i < 1000) {opti();}
          }, 5);
        }
      }
    });
  }

  $(window).scroll(function(event) {
    scrollAnimation();
  });

  function scrollAnimation() {
    $('.scroll.fadeup').each(function(index, el) {
      if(($(window).scrollTop() + $(window).outerHeight()) >= ($(this).offset().top+$(this).outerHeight()-20)) {
        setTimeout(function() {
          //$(el).css('opacity', '1');
          $(el).removeClass('fadeup');
        }, parseInt($(this).data('scroll')));
      }
    });
  }

  $('section.sec1 .scroll-down a[href*=#]').stop().click(function(event) {
    if(location.pathname.replace(/^\//,'') === this.pathname.replace(/^\//,'') && location.hostname === this.hostname) {
      var hash = this.hash;
      var ziel = $(this.hash);
      if(ziel.length) {
        var abstand_top = ziel.offset().top;
        $('html, body').animate({scrollTop: abstand_top}, 800, function() {
          window.location.hash = hash;
        });
        return false;
      }
    }
  });

  $('.content section.sec6 div.navigation div.dot').each(function(index, el) {
    $(this).click(function(event) {
      $('.content section.sec6 div.navigation div.dot').each(function(index, el) {
        $(this).removeClass('active');
      });
      $(this).addClass('active');
      $('.content section.sec6 div.slider div.images').css('left', '-' + (index * $('.content section.sec6 div.slider').outerWidth()) + 'px');
    });
  });



  /* SWIPE */

  document.querySelector('.content section.sec6 div.sec-content div.slider div.images').addEventListener('touchstart', handleTouchStart, false);
  document.querySelector('.content section.sec6 div.sec-content div.slider div.images').addEventListener('touchmove', handleTouchMove, false);

  var xDown = null;
  var yDown = null;

  function handleTouchStart(evt) {
      xDown = evt.touches[0].clientX;
      yDown = evt.touches[0].clientY;
  };

  function handleTouchMove(evt) {
      if ( ! xDown || ! yDown ) {
          return;
      }

      var xUp = evt.touches[0].clientX;
      var yUp = evt.touches[0].clientY;

      var xDiff = xDown - xUp;
      var yDiff = yDown - yUp;

      if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {
          if ( xDiff > 0 ) {
            /* left swipe */
            var active = 0;
            $('.content section.sec6 div.navigation div.dot').each(function(index, el) {
              if($(this).hasClass('active')) {
                if(index < 3) { active = index; } else { active = 2; }
                $(this).removeClass('active');
              }
            });
            $('.content section.sec6 div.navigation div.dot:eq(' + (active+1) + ')').addClass('active');
            $('.content section.sec6 div.slider div.images').css('left', '-' + ((active+1) * $('.content section.sec6 div.slider').outerWidth()) + 'px');
          } else {
              /* right swipe */
              var active = 0;
              $('.content section.sec6 div.navigation div.dot').each(function(index, el) {
                if($(this).hasClass('active')) {
                  if(index > 0) { active = index; } else { active = 1; }
                  $(this).removeClass('active');
                }
              });
              $('.content section.sec6 div.navigation div.dot:eq(' + (active-1) + ')').addClass('active');
              $('.content section.sec6 div.slider div.images').css('left', '-' + ((active-1) * $('.content section.sec6 div.slider').outerWidth()) + 'px');
          }
      }
      xDown = null;
      yDown = null;
  };

});
