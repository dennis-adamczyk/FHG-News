$(document).ready(function() {

  function setReplyClick() {
    $('#content .diskussion .comment .reply-button').unbind("click");
    $('#content .diskussion .comment .reply-button').click(function(event) {
      if($('#content > .write textarea').attr('disabled') != undefined) {
        alert('Du musst dich zuerst anmelden!');
        $('div.reply-write').remove();
      } else {
        if($('.reply-write').length && $('.reply-write').parent().get(0) === $(this).parent().get(0)) {
          $('div.reply-write').remove();
        } else {
          $('div.reply-write').remove();
          var cID = $(this).attr('id');
          cID = cID.substring(4, cID.length);
          $(this).parent().append('<div class="reply-write">' +
            '<p>Ich</p>' +
            '<textarea onkeyup="CheckTextAreaHeight(this)" id="re-wr" rows="1" placeholder="' + ($('#content > .write textarea').attr('placeholder')).replace('Kommentar', 'Antwort') + '"); ?></textarea>' +
            '<img src="img/send_black.svg" />' +
          '</div>');
          setTimeout(function() {
            $('.reply-write > img').click(function(event) {
              var TEXT = $('.reply-write > textarea').val();
              setTimeout(function() {
                $('.reply-write > textarea').val('');
              }, 10);
              $.ajax({
                url: './discussion/reply.php',
                type: 'POST',
                data: {
                  id: cID,
                  text: TEXT
                },
                cache: false,
                success: function(data) {
                  if(data == "SUCCESS") {
                    $('.diskussion .reply-write').remove();
                    $('#uuid' + cID).siblings('.reply').remove();

                    $.ajax({
                      url: './discussion/data.json',
                      type: 'GET',
                      dataType: 'json',
                      cache: false,
                      success: function(data) {
                        $(data.disc).each(function(index, value) {
                          if(value.id == cID) {
                            $('#uuid' + cID).parent().append(getReplys(value.reply));
                          }
                        });
                      }
                    });

                  }
                }
              });

            });
          }, 20);
          setTimeout(function() {
            $('#re-wr').focus();
          }, 500);
        }
      }
    });
  }

  var $discussion = $('#content .diskussion');

  $('#content .write img').click(function(event) {
    var TEXT = $('#content .write textarea').val();
    TEXT = TEXT.replace("\\n", "<br>");
    setTimeout(function() {
      $('#content .write textarea').val('');
    }, 10);
    $.ajax({
      url: './discussion/send.php',
      type: 'POST',
      data: {text: TEXT},
      cache: false,
      success: function(data) {
        if(data == 'SUCCESS') {
          $('#content .write textarea').trigger('keyup');
          $.ajax({
            url: './discussion/data.json',
            type: 'GET',
            dataType: 'json',
            cache: false,
            success: function(data) {
              var dataLength = data.disc.length;
              var nowI = 0;
              $(data.disc).each(function(index, value) {
                nowI++;
                if(nowI === dataLength) {
                  var name = getName(value.from_id);
                  var nameWithStrokes = name.replace(' ', '-');
                  $discussion.prepend('<div class="comment">' +
                  '<p class="name"><a href="/user/' + nameWithStrokes + '">' + name + '</a></p>' +
                  '<p class="time">' + getTime(value.timestamp) + '</p>' +
                  '<p class="text">' + value.text + '</p>' +
                  '<div class="reply-button" id="uuid' + value.id + '"><p class="reply-button-text" unselectable="on">ANTWORTEN</p></div>' +
                  (((value.reply).length != 0) ? getReplys(value.reply) : '') +
                  '</div>');
                }
              });
              $('#content .diskussion .comment').css('display', 'block');
              $('#content .diskussion .comment').css('opacity', '1');
              setReplyClick();
            }
          });
        }
      }
    });

  });

  $('p.name a').attr('href', '/user/' + $(this).val());

  $.ajax({
    url: './discussion/data.json',
    type: 'GET',
    dataType: 'json',
    cache: false,
    success: function(data) {
      $(data.disc).each(function(index, value) {
        var name = getName(value.from_id);
        var nameWithStrokes = name.replace(' ', '-');
        $discussion.prepend('<div class="comment">' +
        '<p class="name"><a href="/user/' + nameWithStrokes + '">' + name + '</a></p>' +
        '<p class="time">' + getTime(value.timestamp) + '</p>' +
        '<p class="text">' + value.text + '</p>' +
        '<div class="reply-button" id="uuid' + value.id + '"><p class="reply-button-text" unselectable="on">ANTWORTEN</p></div>' +
        (((value.reply).length != 0) ? getReplys(value.reply) : '') +
        '</div>');
      });
      $('#content .diskussion .loader').css('opacity', '0');
      setTimeout(function() {
        $('#content .diskussion .loader').css('display', 'none');
      }, 200);
      $('#content .diskussion .comment').css('display', 'block');
      setTimeout(function() {
        $('#content .diskussion .comment').css('opacity', '1');
      }, 20);

      var diskussionHeight = 0;
      $('#content .diskussion .comment').each(function(index, value) {
        diskussionHeight += $(value).outerHeight();
      });
      $('#content .diskussion').css('height', '50px');
      $('#content .diskussion').css('height', diskussionHeight + 'px');
      setTimeout(function() {
        $('#content .diskussion').css('height', 'auto');
      }, 350);

      setReplyClick();
    }
  });

  function getReplys(replys) {
    var output = '';
    replys.forEach(function(reply) {
      var name = getName(reply.from_id);
      var nameWithStrokes = name.replace(' ', '-');
      var text = '<div class="reply">' +
      '<p class="name"><a href="/user/' + nameWithStrokes + '">' + name + '</a></p>' +
      '<p class="time">' + getTime(reply.timestamp) + '</p>' +
      '<p class="text">' + reply.text + '</p>' +
      '</div>';
      output += text;
    });
    return output;
  }

  function getName(id) {
    var result = false;
    $.ajax({
      type: "POST",
      url: './discussion/getName.php',
      data: ({ID: id}),
      async: false,
      success: function(data) {
        result = data;
      }
    });
    return result;
  }

  function getTime(timestamp) {
    var result = false;
    $.ajax({
      type: "POST",
      url: './discussion/getTime.php',
      data: ({TIME: timestamp}),
      async: false,
      success: function(data) {
        result = data;
      }
    });
    return result;
  }

});

function CheckTextAreaHeight(elem) {
  $(elem).on('input selectionchange propertychange',function(e) {
    $(this).height(30);
    $(this).height(this.scrollHeight + parseFloat($(this).css("borderTopWidth")) + parseFloat($(this).css("borderBottomWidth")));
  });
}



/*function CheckTextAreaHeight(tarea) {
  var nCounter = 2;
  var sNeedle = "\n";

  for (var i = 0; i < tarea.value.length; i++) {
    if (sNeedle == tarea.value.substr(i,sNeedle.length)) {
      nCounter++;
    }
  }
  tarea.rows = nCounter;
}*/
