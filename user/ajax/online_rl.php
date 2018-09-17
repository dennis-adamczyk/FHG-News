<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
$this_page = "";

$online = get_online_time($_POST['user_id']);
$now = time();
if(($now - $online) < 6) {
  echo("ON");
} else {
  echo("OFF");
}
?>
