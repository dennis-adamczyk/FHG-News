<?

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/system/init.php";


$errors = array();

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']);
$msg = trim($_POST['message']);
$enter = boolval($_POST['enter']);

if(!isset($first_name)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($first_name)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($first_name) < 3) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
}

if(!isset($last_name)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($last_name)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($last_name) < 3) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
}

if(!isset($email)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($email)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($email) == 0) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(stristr($email, ' ') !== false) {
  $errors[] = "2|In diesem Feld sind keine Leerzeichen erlaubt";
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "2|Bitte gebe eine richtige E-Mail-Adresse an";
}

if(!isset($subject)) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($subject)) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($subject) == 0) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
}

if(!isset($msg)) {
  $errors[] = "4|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($msg)) {
  $errors[] = "4|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($msg) < 20) {
  $errors[] = "4|Gebe mindestens 20 Zeichen ein";
}

foreach ($errors as $error) {
  echo $error . ";";
}

if(empty($errors)) {
  if($enter === true) {
    $success = contact($first_name, $last_name, $email, $subject, $msg);
    
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
