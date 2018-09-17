$(document).ready(function () {

  function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }
  
  $('input#send').click(function (e) {
    if(validateEmail($('input#email').val())) {
      $.ajax({
        type: "post",
        url: "writeLetter.php",
        data: {data: $('input#email').val()},
        success: function (response) {
          if(response !== "ERROR")
            alert('Du hast den Newsletter erfolgreich mit der E-Mail-Adresse ' + $('input#email').val() + ' abonniert.');
            $('input#email').text("");
        }
      });
    } else {
      alert('Diese E-Mail-Adresse ist nicht gültig!')
    }
    
  });

});