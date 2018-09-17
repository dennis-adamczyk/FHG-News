<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$from_id = $_POST['ID'];

$target_data = user_data($from_id, 'first_name', 'last_name');
$return_data = $target_data[0] . ' ' . $target_data[1];

echo($return_data);
?>
