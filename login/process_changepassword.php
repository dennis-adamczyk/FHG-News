<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
protect_page();

$errors = array();

$current_pw = $_POST['current_password'];
$pw1 = trim($_POST['password1']);
$pw2 = trim($_POST['password2']);
$enter = boolval($_POST['enter']);

if(!isset($current_pw)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($current_pw)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($current_pw) == 0) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(stristr(' ', $current_pw) !== false) {
  $errors[] = "0|In diesem Feld sind keine Leerzeichen erlaubt";
} else if(sha1($current_pw) != $user_data['password']) {
  $errors[] = "0|Das Passwort ist inkorrekt";
}

if(!isset($pw1)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($pw1)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($pw1) == 0) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(stristr(' ', $pw1) !== false) {
  $errors[] = "1|In diesem Feld sind keine Leerzeichen erlaubt";
} else if($_POST['safe'] <= 1) {
  $errors[] = "1|Die Sicherheit muss mind. ausrechend sein";
}

if(!isset($pw2)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($pw2)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($pw2) == 0) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(stristr(' ', $pw2) !== false) {
  $errors[] = "2|In diesem Feld sind keine Leerzeichen erlaubt";
} else if($pw1 !== $pw2) {
  $errors[] = "2|Die Passwörter stimmen nicht überein";
}

foreach ($errors as $error) {
  echo $error . ";";
}

if(empty($errors)) {
  if($enter === true) {
    $success = change_password($session_user_id, $pw1);
    if($success === true) {

      echo "SUCCESS";
      exit();
    } else {
      echo "FAILURE";
      exit();
    }
  } else {
    echo " ";
    exit();
  }
}

?>
