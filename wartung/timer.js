$(document).ready(function() {

  var ReleaseDate = new Date("2017-10-20T17:00:00").getTime();
  var TimerFinction = setInterval(function() {
    setCountDown();
  }, 1000);
  setCountDown();

  function setCountDown() {
    var DatumHeute = new Date().getTime();
    var Differenz = ReleaseDate - DatumHeute;

    var d = Math.floor(Differenz / (1000*60*60*24));
    var h = Math.floor((Differenz % (1000*60*60*24)) / (1000*60*60));
    var m = Math.floor((Differenz % (1000*60*60)) / (1000*60));
    var s = Math.floor((Differenz % (1000*60)) / 1000);

    $('#timer').html("<span>" + d + (d == 1 ? "<br><i>Tag</i></span><span>" : "<br><i>Tage</i></span><span>") +
    h + (h == 1 ? "<br><i>Stunde</i></span><span>" : "<br><i>Stunden</i></span><span>") +
    m + (m == 1 ? "<br><i>Minute</i></span><span>" : "<br><i>Minuten</i></span><span>") +
    s + (s == 1 ? "<br><i>Sekunde</i></span>" : "<br><i>Sekunden</i></span>"));
  }

});
