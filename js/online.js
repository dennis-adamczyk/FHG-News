$(document).ready(function() {

  function callOnline() {
    $.post("/core/functions/online.php",
      {
        user_id: USER_ID
      }, function(data) {
        setTimeout(function() {
          callOnline();
        }, 5000);
      });
  }

  callOnline();
});
