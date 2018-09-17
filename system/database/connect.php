<?
$mysql_server = 'localhost';
$mysql_username = 'USERNAME';
$mysql_password = 'PASSWORD';
$mysql_database = 'DATABASE_NAME';

mysqli_report(MYSQLI_REPORT_OFF);
error_reporting(0);

global $mysqli;
$mysqli = new mysqli($mysql_server, $mysql_username, $mysql_password, $mysql_database);
if($mysqli->connect_error) {
  die('Error: Zugang zur Datenbank fehlgeschlagen!');
}
mysqli_set_charset($mysqli, "utf8");
?>
