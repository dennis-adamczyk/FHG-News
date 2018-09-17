$(document).ready(function() {

  /* HEADER-MORE-MENU */

  setPageTitle();

  function setPageTitle() {
    if($(window).width() < 1480) {
      $('header p.header-title').html(short_title);
    } else {
      $('header p.header-title').html(long_title);
    }
  };

  $('header .header-more').click(function(event) {
    var $menu = $('div.header-more-menu');
    var $overlay = $('div.header-more-menu-overlay');
    $menu.show({duration: 200});
    $overlay.css('display', 'block');
  });

  $('div.header-more-menu-overlay').on('touchstart mousedown click', function(event) {
    $('div.header-more-menu').fadeOut({duration: 200});
    $(this).css('display', 'none');
  });

  $('div.header-more-menu ul li').click(function(event) {
    console.log('XXXXXX');
    window.location = $(this).data('link');
  });

  /* NOTIFICATIONS */

  $('header .header-notifications').click(function(event) {
    var $menu = $('div.header-notifications-menu');
    var $overlay = $('div.header-notifications-menu-overlay');
    if($overlay.css('display') == 'none' && $menu.css('display') == 'none') {
      $menu.show({duration: 200});
      $overlay.css('display', 'block');
      $('header .header-notifications i').first().css('display', 'none');
      $('header .header-notifications i').last().css('display', 'block');
    }
  });

  $('div.header-notifications-menu-overlay').on('touchstart mousedown click', function(event) {
    $('div.header-notifications-menu').hide({duration: 200});
    $(this).css('display', 'none');
    $('header .header-notifications i').first().css('display', 'block');
    $('header .header-notifications i').last().css('display', 'none');
  });

  /* NAVIGATION */

  $('nav ul.list li.' + (short_title.includes('<') ? "x" : short_title.replace(" ", "-")) + ' p').css('color', '#424242');
  $('nav ul.list li.' + (short_title.includes('<') ? "x" : short_title.replace(" ", "-")) + ' i').css('color', '#424242');
  $('nav ul.list li.' + (short_title.includes('<') ? "x" : short_title.replace(" ", "-"))).css('background-color', '#EEEEEE');

  $('nav').css('width', getNavDrawerWidth());

  $(window).resize(function(event) {
    setPageTitle();/* HEADER-TITLE */

    $('nav').css('width', getNavDrawerWidth());
    if($(window).width() >= 1480) {
      if($('.nav-overlay').css('display') == 'block') {
        $('nav').removeAttr('style');
        setTimeout(function() {
          $('nav').css('width', getNavDrawerWidth());
        }, 20);
        $('div.nav-overlay').removeAttr('style');
      }
    }
  });

  function getNavDrawerWidth() {
    var nav_width = 0;
    if($(window).width() < 800) {
      nav_width = $(window).width() - 56;
      if(nav_width > 280) {
        nav_width = 280;
      }
    } else if($(window).width() < 1480) {
      nav_width = $(window).width() - 64;
      if(nav_width > 320) {
        nav_width = 320;
      }
    } else {
      nav_width = 256;
    }
    return nav_width + "px";
  };

  $('nav li[data-link]').click(function(event) {
    $('header .progress').show('400');
    var link = $(this).data('link');

    if($(window).width() >= 1480) {
      window.location = link;
    } else {
      $('nav').css('left', '-330px');
      $('div.nav-overlay').css('opacity', '0');
      setTimeout(function() {
        $('div.nav-overlay').removeAttr('style');
        setTimeout(function() {
          $('nav').removeAttr('style');
          setTimeout(function() {
            $('nav').css('width', getNavDrawerWidth());
          }, 20);
        }, 100);
        window.location = link;
      }, 300);
    }
  });

  $('div.logo[data-link]').click(function(event) {
    var link = $(this).data('link');

    if($(window).width() >= 1480) {
      window.location = link;
    } else {
      $('nav').css('left', '-330px');
      $('div.nav-overlay').css('opacity', '0');
      setTimeout(function() {
        $('div.nav-overlay').removeAttr('style');
        setTimeout(function() {
          $('nav').removeAttr('style');
          setTimeout(function() {
            $('nav').css('width', getNavDrawerWidth());
          }, 20);
        }, 100);
        window.location = link;
      }, 300);
    }
  });

  $('header div.header-menu').click(function(event) {
    if($(window).width() < 1480) {
      $('nav').css('left', '0');
      $('div.nav-overlay').css('display', 'block');
      setTimeout(function() {
      $('div.nav-overlay').css('opacity', '1');
      }, 20);
    }
  });

  $('div.nav-overlay').on('touchstart mousedown click', function(event) {
    if($(window).width() < 1480) {
      $('nav').css('left', '-330px');
      $('div.nav-overlay').css('opacity', '0');
      setTimeout(function() {
        $('div.nav-overlay').removeAttr('style');
        setTimeout(function() {
          $('nav').removeAttr('style');
          setTimeout(function() {
            $('nav').css('width', getNavDrawerWidth());
          }, 20);
        }, 100);
      }, 300);
    } else {
      $('nav').removeAttr('style');
      setTimeout(function() {
        $('nav').css('width', getNavDrawerWidth());
      }, 20);
      $('div.nav-overlay').removeAttr('style');
    }
    return false;
  });

  document.addEventListener('touchstart', handleTouchStart, false);
  document.addEventListener('touchmove', handleTouchMove, false);

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

    if(xDown > 20) {
      return;
    }

    var xUp = evt.touches[0].clientX;
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

    if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {
      if ( xDiff < 0 ) {
        $('nav').css('left', '0');
        $('div.nav-overlay').css('display', 'block');
        setTimeout(function() {
          $('div.nav-overlay').css('opacity', '1');
        }, 20);
      }
    }

    xDown = null;
    yDown = null;
  };

  /* FOOTER */

  setFooter();

  setInterval(function() {
    setFooter();
  }, 300);

  function setFooter() {
    var $footer = $('div.content footer');
    if($('div.content').outerHeight() < ($(window).height() - ($('div.content').css('top')).replace("px", ""))) {
      $footer.css('position', 'fixed');
      $footer.css('left', $('div.content').css('left'));
    } else {
      $footer.removeAttr('style');
    }
  }

  /* RIPPLE */

  var config = {
    duration: 250
  }

  Waves.attach('header .header-menu');
  Waves.attach('header .header-notifications');
  Waves.attach('header .header-more');
  Waves.attach('div.header-more-menu ul li', ['waves-block']);
  Waves.attach('nav ul.list li.list-item');
  Waves.init(config);


});
