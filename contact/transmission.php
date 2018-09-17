<?

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$errors = array();

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']);
$msg = trim($_POST['message']);
$enter = boolval($_POST['enter']);

if(!isset($name)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($name)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($name) < 5) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(substr_count($name, ' ') !== 1 && substr_count($name, ' ') !== 2) {
  $errors[] = "0|Bitte gebe ein: 'VORNAME NACHNAME'";
}

if(!isset($email)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($email)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($email) == 0) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(stristr($email, ' ') !== false) {
  $errors[] = "1|In diesem Feld sind keine Leerzeichen erlaubt";
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "1|Bitte gebe ihre richtige E-Mail-Adresse an";
}

if(!isset($subject)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($subject)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($subject) == 0) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
}

if(!isset($msg)) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($msg)) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($msg) < 5) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
}

foreach ($errors as $error) {
  echo $error . ";";
}

if(empty($errors)) {
  if($enter === true) {
    $success = contact($name, $email, $subject, $msg);
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
