$(document).ready(function() {

  var toastVisible = false;

  function showToast() {
    if(toastVisible === true) {
      return;
    }
    toastVisible = true;
    $('.content .toast').css('margin-top', '-' + $('.content .toast').outerHeight() + 'px');
    $('.content .toast p').css('opacity', '1');
    setTimeout(function() {
      $('.content .toast').css('margin-top', '0');
      setTimeout(function() {
        $('.content .toast').removeAttr('style');
        $('.content .toast p').removeAttr('style');
        toastVisible = false;
      }, 180);
    }, 3000);
  }

  /* ###################################################### */
  /* ################# TABLE MYSQL ######################## */
  /* ###################################################### */

  $.post('system/data.php', {}, function(data) {
    $('.content .main div.plan div.table table tbody').html(data);
  });

  /* ###################################################### */
  /* ################# TEXTS JSON ######################### */
  /* ###################################################### */

  $.post('texts.json', {}, function(data) {
    $('.content .main h1.title').html(data['title']);
    $('.content .main p.information').html(data['information']);
  });


  /* ###################################################### */
  /* ################# LOGGED_IN ########################## */
  /* ###################################################### */

  $('nav ul.list li.Redaktion').prepend('<ul><li class="OrgaPlan"><i class="material-icons">view_list</i><p>OrgaPlan</p></li></ul>');
  $('nav ul.list li.Redaktion ul').insertAfter('nav ul.list li.Redaktion');

  /* ###################################################### */
  /* ################# PRINT ############################## */
  /* ###################################################### */

  $('.content .main div.plan div.top i.print').stop().click(function(event) {
    printContent();
  });

  function printContent() {
    $('header').css('display', 'none');
    $('nav').css('display', 'none');
    $('.content').css('left', '0');
    $('.content').css('top', '0');
    $('.content footer').css('display', 'none');
    $('.content .toast').css('display', 'none');
    $('.content .main .plan .top i').css('display', 'none');
    window.print();
    $('header').css('display', 'block');
    $('nav').css('display', 'block');
    $('.content').removeAttr('style');
    $('.content footer').css('display', 'block');
    $('.content .toast').css('display', 'block');
    $('.content .main .plan .top i').css('display', 'block');
    $(window).trigger('resize');
  }

  /* ###################################################### */
  /* ################# DOWNLOAD ########################### */
  /* ###################################################### */

  $('.content .main div.plan div.top i.download').stop().click(function(event) {
    var css = "";
    $.post('css/page.css', {}, function(data) {
      css = data;

      $.post('/css/layout.css', {}, function(data) {
        css2 = data;

        var htmlContent = ['<head>' + $('head').html() + '</head><body><div class="content">' + $('.content').html() + '</div><style>' + css + '.content footer {display: none;} *, body, html {font-family: Roboto;}</style></body>'];
        var bl = new Blob(htmlContent, {type: "text/html"});
        var a = document.createElement("a");
        a.href = URL.createObjectURL(bl);
        a.download = "OrgaPlan Stand " + new Date().toLocaleDateString("de-DE").replace('.', '-').replace('.', '-').replace('.', '-') + " FHG News 3/2018";
        a.hidden = true;
        document.body.appendChild(a);
        a.innerHTML = "something random - nobody will see this, it doesn't matter what you put here";
        a.click();
      });
    });
  });

});
