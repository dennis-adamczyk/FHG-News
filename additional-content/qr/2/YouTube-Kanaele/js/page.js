$(document).ready(function() {

  $('.content .main div.channel div.more').click(function(event) {
    $(this).parent().find('div.subchannel-group').slideToggle('250');
  });

  $('.content .main div.channel div.to-channel').click(function(event) {
    window.open($(this).data('yt'), '_blank'); 
  });

  Waves.attach('.content .main .channel .to-channel');
  Waves.attach('.content .main .channel .more');

});
