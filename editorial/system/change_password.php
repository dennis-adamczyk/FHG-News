<?

$root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";

$errors = array();

$password1 = trim($_POST['password1']);
$password2 = trim($_POST['password2']);
$enter = boolval($_POST['enter']);

if(!isset($password1)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($password1)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($password1) <= 3) {
  $errors[] = "0|Dein Password muss mehr als 3 Zeichen enthalten";
}

if(!isset($password2)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($password2)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($password2) < 1) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if($password2 !== $password1) {
  $errors[] = "1|Die Passwörter stimmen nicht überein";
}

foreach ($errors as $error) {
  echo $error . ";";
}

if(empty($errors)) {
  if($enter === true) {
    $changed = change_password($session_user_id, $password2);
    if($changed == true) {
      echo "SUCCESS";
    } else {
      echo "FAILURE";
    }
    exit();
  } else {
    echo " ";
    exit();
  }
}
