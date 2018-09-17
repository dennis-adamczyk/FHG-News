<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
if(is_logged_in()) {
  include "$root/includes/widgets/loggedin.php";
} else {
  include "$root/includes/widgets/login.php";
}
?>
