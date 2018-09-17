<?
session_start();
require "database/connect.php";
require "functions/general.php";
require "functions/users.php";
require "perms/functions.php";

$current_file = $_SERVER['SCRIPT_NAME'];

$user_data = null;
$session_user_id = null;

if ($_COOKIE['user_id'] !== null) {
  $_SESSION['user_id'] = decodeRand($_COOKIE['user_id']);
  refreshRememberCookie();
}

if (is_logged_in() === true) {
  $session_user_id = $_SESSION['user_id'];
  $user_data = user_data($session_user_id, 'user_id', 'first_name', 'last_name', 'class', 'email', 'password', 'password_recover', 'profile_pic', 'role', 'online', 'official', 'gender', 'active');
  if (user_active($user_data['email']) === false) {
    $mail = $user_data['email'];
    $parts = explode('@', $mail);
    $mail = end($parts);
    session_destroy();
    header('Location: /index.php?popup=please-activate&mail=' . $mail);
    exit();
  }
  if ($current_file !== '/login/changepassword.php' && $current_file !== '/login/process_changepassword.php' && $user_data['password_recover'] == 1) {
    header('Location: /login/changepassword.php');
    exit();
  }
}

$errors = array();

?>
