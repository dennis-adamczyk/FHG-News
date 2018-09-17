$(document).ready(function() {
  $(window).scroll(function(event) {
    /* BOOK */
    var BOOK_HEIGHT = $('.heft .book_box .book').outerHeight();
    var SCROLL_TOP = $(window).scrollTop();
    if(SCROLL_TOP > BOOK_HEIGHT) {

    } else {
      var BOOK_ONE_PROCENT = BOOK_HEIGHT / 100;
      $('.heft .book_box .book').css('transform', 'rotate3d(0, 1, 0, ' + (SCROLL_TOP/BOOK_ONE_PROCENT/100*35) + 'deg)');
    }


    /* PRICE */

    var $price = $('.buy-price .content .price');
    var bottom_of_price = $price.offset().top + $price.outerHeight();
    var bottom_of_window = SCROLL_TOP + window.screen.availHeight;
    var price_is_animated = false;

    if(bottom_of_price < bottom_of_window) {
      if(price_is_animated === false) {
        $('.buy-price .content .price .euro p').css('top', '-335px');
      }
      price_is_animated = true;
    }
  });

});

/* COVER LOADER */

function imgReady() {
  $('#content .book_box .book img').css('opacity', '1');
  $('#content .book_box .book .loader').css('opacity', '0');
  setTimeout(function() {
    $('#content .book_box .book .loader').css('display', 'none');
  }, 110);
};
