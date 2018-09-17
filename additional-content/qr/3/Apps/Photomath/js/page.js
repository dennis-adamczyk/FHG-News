$(document).ready(function() {

  var androidOS = ["Linux armv7l", "Linux aarch64", "Linux i686", "Linux armv8l", "Android"];
  var iOS = ["iPhone", "iPod", "iPad", "iPhone Simulator", "iPod Simulator", "iPad Simulator", "Macintosh", "MacIntel",
            "MacPPC", "Mac68K", "Pike v7.6 release 92", "Pike v7.8 release 517"];
  var windowsOS = ["OS/2", "Pocket PC", "Windows", "Win16", "Win32", "Win64", "WinCE"];

  if($.inArray(window.navigator.platform, androidOS) >= 0 || window.navigator.platform == null) {
    /* Android */
    window.location.replace("https://play.google.com/store/apps/details?id=com.microblink.photomath&hl=de");
  } else if($.inArray(window.navigator.platform, iOS) >= 0) {
    /* iOS */
    window.location.replace("https://itunes.apple.com/de/app/photomath/id919087726?mt=8");
  } else if($.inArray(window.navigator.platform, windowsOS) >= 0) {
    /* Windows */
    window.location.replace("https://play.google.com/store/apps/details?id=com.microblink.photomath&hl=de");
  } else {
    window.location.replace("https://play.google.com/store/apps/details?id=com.microblink.photomath&hl=de");
  }

});
