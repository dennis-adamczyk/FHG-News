<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$errors = array();

$enter = boolval($_POST['enter']);

if($_GET['mode'] == 'email') {
  $first_name = trim($_POST['first_name']);
  $last_name = trim($_POST['last_name']);

  if(!isset($first_name)) {
    $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
  } else if(ctype_space($first_name)) {
    $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
  } else if(strlen($first_name) == 0) {
    $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
  } else if(!ctype_alpha(str_replace(' ', '', $first_name))) {
    $errors[] = "0|In diesem Feld sind nur Buchstaben erlaubt";
  }

  if(!isset($last_name)) {
    $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
  } else if(ctype_space($last_name)) {
    $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
  } else if(strlen($last_name) == 0) {
    $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
  } else if(!ctype_alpha(str_replace(' ', '', $last_name))) {
    $errors[] = "1|In diesem Feld sind nur Buchstaben erlaubt";
  }

  if(empty($errors)) {
    if(name_exists($first_name, $last_name) === false) {
      $errors[] = "2|Diese Namen-Kombination existiert nicht";
    }
  }

  if(empty($errors)) {
    if($enter === true) {
      $email = recover('email', $first_name, $last_name);
      if($email !== false) {
        echo ">" . $email;
        exit();
      } else {
        echo "FAILURE";
        exit();
      }
    }
  }

  if(!empty($errors)) {
    foreach ($errors as $error) {
      echo $error . ";";
    }
  }

} else if($_GET['mode'] == 'password') {
  $email = trim($_POST['email']);

  if(!isset($email)) {
    $errors[] = "Dieses Feld ist ein Pflichtfeld";
  } else if(ctype_space($email)) {
    $errors[] = "Dieses Feld ist ein Pflichtfeld";
  } else if(strlen($email) == 0) {
    $errors[] = "Dieses Feld ist ein Pflichtfeld";
  } else if(stristr($email, ' ') !== false) {
    $errors[] = "In diesem Feld sind keine Leerzeichen erlaubt";
  } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Bitte gebe ihre richtige E-Mail-Adresse an";
  } else if(!user_exists($email)) {
    $errors[] = "Diese E-Mail-Adresse wird von niemandem verwendet";
  }

  if(empty($errors)) {
    if($enter == true) {
      $success = recover($_GET['mode'], $email);
      if($success === true) {
        echo "SUCCESS";
        exit();
      } else {
        echo "FAILURE";
        exit();
      }
    } else {
      echo null;
      exit();
    }
  }

  if(!empty($errors)) {
    echo $errors[0];
  }
}
?>
