$(document).ready(function() {

  var imgAmount = 7;

  for(var i = 0; i < imgAmount; i++) {
    var $imgContainer = $('.content .main .image-container');

    $imgContainer.append('<div class="image" style=\'background-image: url("img/' + (i+1) + '.jpeg")\'></div>');
  }

  $('.content .main .image-container .image').click(function(event) {
    var lightboxID = $(this).css('background-image').replace('url("https://duispaper.de/additional-content/qr/2/AbschlussfahrtDer9er/img/', '');
    lightboxID = lightboxID.replace('url("https://www.duispaper.de/additional-content/qr/2/AbschlussfahrtDer9er/img/', '');
    lightboxID = lightboxID.replace('.jpeg")', '');
    window.location = "?lightbox=" + lightboxID;
  });

  if(~window.location.href.indexOf("?lightbox")) {
    var $imgCount = $('.content .lightbox .header .img-count');
    $imgCount.text($imgCount.text() + imgAmount);

    optimizeImage();

    $(window).resize(function(event) {
      optimizeImage();
    });

    $('.content .main').remove();

    $('.content .lightbox .header .close').click(function(event) {
      window.location = window.location.pathname;
    });

    var url = new URL(window.location.href);
    var image = parseInt(url.searchParams.get("lightbox"));

    $('.content .lightbox .header .download').click(function(event) {
      var link = document.createElement('a');
      link.href = 'img/' + image + '.jpeg';
      link.download = 'Abschlussfarhrt der 9er - ' + image + '.jpg';
      document.body.appendChild(link);
      link.click();
    });

    $('.content .lightbox .img-preview .prev').click(function(event) {
      if(image == 1) {
        window.location = "?lightbox=" + imgAmount;
      } else {
        window.location = "?lightbox=" + (image-1);
      }
    });

    $('.content .lightbox .img-preview .next').click(function(event) {
      if(image == imgAmount) {
        window.location = "?lightbox=1";
      } else {
        window.location = "?lightbox=" + (image+1);
      }
    });

    $('.content .lightbox .img-preview').click(function(event) {
      $('.content .lightbox .header').fadeToggle('200');
      $('.content .lightbox .img-preview .prev').fadeToggle('200');
      $('.content .lightbox .img-preview .next').fadeToggle('200');
    });

    $('.content .lightbox .img-preview .next').click(function(event) {
      $('.content .lightbox .header').fadeToggle('2');
      $('.content .lightbox .img-preview .prev').fadeToggle('2');
      $('.content .lightbox .img-preview .next').fadeToggle('2');
    });

    $('.content .lightbox .img-preview .prev').click(function(event) {
      $('.content .lightbox .header').fadeToggle('2');
      $('.content .lightbox .img-preview .prev').fadeToggle('2');
      $('.content .lightbox .img-preview .next').fadeToggle('2');
    });

    Waves.attach('.content .lightbox .header .close', ['waves-light']);
    Waves.attach('.content .lightbox .header .download', ['waves-light']);
    Waves.attach('.content .lightbox .img-preview .prev', ['waves-light']);
    Waves.attach('.content .lightbox .img-preview .next', ['waves-light']);
  }

  function optimizeImage() {
    var $img = $('.content .lightbox .img-preview img');
    if($img.outerHeight()/$(window).height() > $img.outerWidth()/$(window).width()) {
      $img.css('height', $(window).height());
      $img.css('width', 'auto');
    } else {
      $img.css('width', $(window).width());
      $img.css('height', 'auto');
    }
  }

});
