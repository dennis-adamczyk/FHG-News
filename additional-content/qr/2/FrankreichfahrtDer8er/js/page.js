$(document).ready(function() {

  var imgAmount = 51;
  var vidAmount = 1;

  for(var i = 0; i < imgAmount; i++) {
    var $imgContainer = $('.content .main .image-container');

    $imgContainer.append('<div class="image" style=\'background-image: url("img/thumb/' + (i+1) + '.jpg")\'></div>');
  }
  for(var i = 0; i < vidAmount; i++) {
    var $imgContainer = $('.content .main .image-container');

    $imgContainer.append('<div class="image" style=\'background-image: url("img/thumb/v' + (i+1) + '.jpg")\'></div>');
  }

  $('.content .main .image-container .image').click(function(event) {
    var lightboxID = $(this).css('background-image').replace('url("https://duispaper.de/additional-content/qr/2/FrankreichfahrtDer8er/img/thumb/', '');
    lightboxID = lightboxID.replace('url("https://www.duispaper.de/additional-content/qr/2/FrankreichfahrtDer8er/img/thumb/', '');
    lightboxID = lightboxID.replace('.jpg")', '');
    window.location = "?lightbox=" + lightboxID;
  });

  if(~window.location.href.indexOf("?lightbox")) {
    var $imgCount = $('.content .lightbox .header .img-count');
    $imgCount.text($imgCount.text() + imgAmount);

    $('.content .lightbox .img-preview img').load(function(event){
      optimizeImage();
    });

    $('.content .lightbox .img-preview video').on('play', function(event){
      optimizeVideo();
    });

    $(window).resize(function(event) {
      optimizeImage();
      optimizeVideo();
    });

    $('.content .main').remove();

    $('.content .lightbox .header .close').click(function(event) {
      window.location = window.location.pathname;
    });

    var url = new URL(window.location.href);
    var param = url.searchParams.get("lightbox").toString();
    var image = (param.includes('v') === true ? (imgAmount + parseInt(param.replace('v', ''))) : (parseInt(param)));

    $('.content .lightbox .header .download').click(function(event) {
      if(image >= imgAmount) {
        var link = document.createElement('a');
        link.href = 'img/v' + (image - imgAmount) + '.mp4';
        link.download = 'Frankreichfahrt der 8er - v' + (image - imgAmount) + '.mp4';
        document.body.appendChild(link);
        link.click();
      } else {
        var link = document.createElement('a');
        link.href = 'img/' + image + '.jpg';
        link.download = 'Frankreichfahrt der 8er - ' + image + '.jpg';
        document.body.appendChild(link);
        link.click();
      }
    });

    $('.content .lightbox .img-preview .prev').click(function(event) {
      if(image == 1) {
        window.location = "?lightbox=" + imgAmount;
      } else {
        window.location = "?lightbox=" + (image-1);
      }
    });

    $('.content .lightbox .img-preview .next').click(function(event) {
      if(image >= imgAmount) {
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

  function optimizeVideo() {
    var $vid = $('.content .lightbox .img-preview video');
    if($vid.outerHeight()/$(window).height() > $vid.outerWidth()/$(window).width()) {
      $vid.css('height', $(window).height());
      $vid.css('width', 'auto');
    } else {
      $vid.css('width', $(window).width());
      $vid.css('height', 'auto');
    }
  }

});
