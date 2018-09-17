<?
/* ERROR REPORTING */
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_GET['code'])) {
  $code = $_GET['code'];
  $jsonContent = file_get_contents('index.json');
  $json = json_decode($jsonContent, true);
  $isValid = false;
  foreach ($json as $key => $value) {
    if($code == $key) {
      header('Location: ' . $value);
      $isValid = true;
    }
  }
  if(!$isValid) {
    header('Location: /additional-content/');
  }
} else {
  header('Location: /additional-content/');
}
?>
