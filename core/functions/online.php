<?
$mysql_server = 'localhost';
$mysql_username = 'USERNAME';
$mysql_password = 'PASSWORD';
$mysql_database = 'DATABASE_NAME';

mysqli_report(MYSQLI_REPORT_OFF);
error_reporting(0);

$mysqli = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_database);
if ($mysqli->connect_error) {
  die('ERROR: Zugang zur Datenbank fehlgeschlagen!');
}

$user_id = $_POST['user_id'];
$sql = "UPDATE `users` SET `online` = '" . time() . "' WHERE `user_id` = " . $user_id;
$query = mysqli_query($mysqli, $sql);
echo(" - ");
?>
