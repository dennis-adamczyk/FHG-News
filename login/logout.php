<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/functions/general.php";
session_start();
session_destroy();
delRememberCookie();
header('Location: /index.php');
?>
