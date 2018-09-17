<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$text = $_POST['text'];
$text = str_replace('<br>', '\n', $text);
$text = sanitize($text);

$cID = (int) $_POST['id'];

if(!isset($text) || ctype_space($text) || strlen($text) == 0) {
  echo "ERROR";
  die();
}

$text = str_replace('\n', '<br>', $text);

$current_data = file_get_contents('data.json');
$array_data = json_decode($current_data, true);
$extra = array(
  "from_id" => (int) $session_user_id,
  "text" => $text,
  "timestamp" => time()
);
$index = 0;
foreach($array_data['disc'] as $comment) {
  if($comment['id'] == $cID) {
    $comment['reply'][] = $extra;
    $array_data['disc'][$index] = $comment;
  }
  $index++;
}
$final_data = json_encode($array_data);
if(file_put_contents('data.json', $final_data)) {
  echo "SUCCESS";
  die();
}
