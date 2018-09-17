try {
  let opts = {
    // Whether to scan continuously for QR codes. If false, use scanner.scan() to manually scan.
    // If true, the scanner emits the "scan" event when a QR code is scanned. Default true.
    continuous: true,

    // The HTML element to use for the camera's video preview. Must be a <video> element.
    // When the camera is active, this element will have the "active" CSS class, otherwise,
    // it will have the "inactive" class. By default, an invisible element will be created to
    // host the video.
    video: document.getElementById('preview'),

    // Whether to horizontally mirror the video preview. This is helpful when trying to
    // scan a QR code with a user-facing camera. Default true.
    mirror: false,

    // Whether to include the scanned image data as part of the scan result. See the "scan" event
    // for image format details. Default false.
    captureImage: false,

    // Only applies to continuous mode. Whether to actively scan when the tab is not active.
    // When false, this reduces CPU usage when the tab is not active. Default true.
    backgroundScan: true,

    // Only applies to continuous mode. The period, in milliseconds, before the same QR code
    // will be recognized in succession. Default 5000 (5 seconds).
    refractoryPeriod: 5000,

    // Only applies to continuous mode. The period, in rendered frames, between scans. A lower scan period
    // increases CPU usage but makes scan response faster. Default 1 (i.e. analyze every frame).
    scanPeriod: 1
  };

  let scanner = new Instascan.Scanner(opts);
  scanner.addListener('scan', function (content) {
    navigator.vibrate(100);
    if(content.substring(0, 4) == "www.") {
      window.location = "http://" + content;
    } else {
      window.location = content;
    }
  });

  Instascan.Camera.getCameras().then(function (cameras) {
    if (cameras.length > 0) {
      if(cameras.length == 2) {
        scanner.start(cameras[1]);
      } else {
        scanner.start(cameras[0]);
      }
    } else {
      alert('Keine Kameras gefunden.');
    }
  }).catch(function (e) {
    alert("Dein Browser unterstützt das QR-Code-Scannen nicht.\nBenutze eine externe QR-Code-Scan-App oder versuche die Internetseite mit einem anderen Browser aufzurufen.");
    window.location = "/";
    console.error(e);
  });
} catch (e) {
  alert("Dein Browser unterstützt das QR-Code-Scannen nicht.\nBenutze eine externe QR-Code-Scan-App oder versuche die Internetseite mit einem anderen Browser aufzurufen.");
  window.location = "/";
  console.error(e);
}
$(document).ready(function() {
  $window = $(window);
  $preview = $('.content video#preview');
  $laser = $('.content .laser');
  $preview.css('height', $window.height() - $('header').outerHeight());
  optimizeLaser($window, $laser);
  $(window).resize(function(event) {
    $preview.css('height', $window.height() - $('header').outerHeight());
    optimizeLaser($window, $laser);
  });

  function optimizeLaser($window, $laser) {
    if($window.height() > $window.width()) {
      $laser.addClass('portrait');
      $laser.removeClass('landscape');
      $laser.removeAttr('style');
      $laser.css('height', $laser.css('width'));
    } else {
      $laser.addClass('landscape');
      $laser.removeClass('portrait');
      $laser.removeAttr('style');
      $laser.css('width', $laser.css('height'));
    }
  }

  $('.content #preview').on("loadeddata", function(event) {
    $('.content .loader').fadeOut('fast');
  });

  // setTimeout(function() {
  //   if($('.content .loader').css('display') == "block") {
  //     window.location = "index.php";
  //   }
  // }, 3500);

  $('.content .help').click(function(event) {
    window.location = "https://www.duispaper.de/help/article/?nr=1";
  });

  Waves.attach('.content .help', ['waves-light']);
});
