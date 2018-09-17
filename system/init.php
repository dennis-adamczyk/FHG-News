<?
  session_start();
  require "database/connect.php";
  require "users.php";
  require "functions.php";

  $current_file = $_SERVER['SCRIPT_NAME'];

  if($_COOKIE['user_id'] !== null) {
    $_SESSION['user_id'] = decodeRand($_COOKIE['user_id']);
      refreshRememberCookie();
  }

  $session_user_id = null;
  if(is_logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
  }

?>
