<?php
if(isset($_POST['data'])) {
  $fp = fopen('js/list.json', 'r+') or die('ERROR');
  $fr = file_get_contents('js/list.json', true);
  $json = json_decode($fr);
  $json[] = $_POST['data'];
  $jsonRaw = json_encode($json);
  fwrite($fp, $jsonRaw);
  fclose($fp);
  echo "SUCCESS";
} else {
  echo "ERROR";
}

?>
