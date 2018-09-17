<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/system/users.php";
session_start();
session_destroy();
delRememberCookie();
header('Location: /editorial/');
?>
