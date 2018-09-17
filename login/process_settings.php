<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
protect_page();
$this_page = "";

if(isset($_GET['action']) && $_GET['action'] == 'validate_field') {
  $field = trim($_POST['field']);
  $value = trim($_POST['value']);

  $errors = array();

  if($field == 'first_name') {
    if(!isset($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($value) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(!ctype_alpha(str_replace(' ', '', $value))) {
      $errors[] = "In diesem Feld sind nur Buchstaben erlaubt";
    }
  } else if($field == 'last_name') {
    if(!isset($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($value) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(!ctype_alpha(str_replace(' ', '', $value))) {
      $errors[] = "In diesem Feld sind nur Buchstaben erlaubt";
    }
  } else if($field == 'email') {
    if(!isset($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($value) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(stristr($value, ' ') !== false) {
      $errors[] = "In diesem Feld sind keine Leerzeichen erlaubt";
    } else if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Bitte gebe eine gültige E-Mail-Adresse an";
    } else if(user_exists($value) === true && $user_data['email'] !== $value) {
      $errors[] = "Diese E-Mail-Adresse wird bereits verwendet";
    }
  } else if($field == 'class') {
    if(!isset($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($value)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($value) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($value) == 2) {
      if(ctype_digit(substr($value, 0, 1))) {
        if((int) substr($value, 0, 1) >= 5 && (int) substr($value, 0, 1) <= 9) {
          if(ctype_alpha(substr($value, 1, 1))) {
            //ERFOLGREICH
          } else {
            $errors[] = "Benutze folgendes Format '[5-9][a-z]'";
          }
        } else {
          $errors[] = "Benutze folgendes Format '[5-9][a-z]'";
        }
      } else if(strtoupper($value) == "EF" || strtoupper($value) == "Q1" || strtoupper($value) == "Q2") {
        //ERFOLGREICH
      } else {
        $errors[] = "Benutze folgendes Format '[5-9][a-z]'/'EF'/'Q[1-2]'";
      }
    } else if(strtoupper($value) == "LEHRER") {
      //ERFOLGREICH
    } else {
      $errors[] = "Benutze folgendes Format '[5-9][a-z]'/'EF'/'Q[1-2]'/'Lehrer'";
    }
  }

  if(empty($errors)) {
    echo "NONE";
  } else {
    echo $errors[0];
  }
} else {

  $errors = array();

  $first_name = trim($_POST['first_name']);
  $last_name = trim($_POST['last_name']);
  $email = trim($_POST['email']);
  $class = trim($_POST['class']);

    if(!isset($first_name)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($first_name)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($first_name) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(!ctype_alpha(str_replace(' ', '', $first_name))) {
      $errors[] = "In diesem Feld sind nur Buchstaben erlaubt";
    }

    if(!isset($last_name)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($last_name)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($last_name) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(!ctype_alpha(str_replace(' ', '', $last_name))) {
      $errors[] = "In diesem Feld sind nur Buchstaben erlaubt";
    }

    if(!isset($email)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($email)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($email) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(stristr($email, ' ') !== false) {
      $errors[] = "In diesem Feld sind keine Leerzeichen erlaubt";
    } else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Bitte gebe eine gültige E-Mail-Adresse an";
    } else if(user_exists($email) === true && $user_data['email'] !== $email) {
      $errors[] = "Diese E-Mail-Adresse wird bereits verwendet";
    }

    if(!isset($class)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(ctype_space($class)) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($class) == 0) {
      $errors[] = "Dieses Feld ist ein Pflichtfeld";
    } else if(strlen($class) == 2) {
      if(ctype_digit(substr($class, 0, 1))) {
        if((int) substr($class, 0, 1) >= 5 && (int) substr($class, 0, 1) <= 9) {
          if(ctype_alpha(substr($class, 1, 1))) {
            //ERFOLGREICH
          } else {
            $errors[] = "Benutze folgendes Format '[5-9][a-z]'";
          }
        } else {
          $errors[] = "Benutze folgendes Format '[5-9][a-z]'";
        }
      } else if(strtoupper($class) == "EF" || strtoupper($class) == "Q1" || strtoupper($class) == "Q2") {
        //ERFOLGREICH
      } else {
        $errors[] = "Benutze folgendes Format '[5-9][a-z]'/'EF'/'Q[1-2]'";
      }
    } else if(strtoupper($class) == "LEHRER") {
      //ERFOLGREICH
    } else {
      $errors[] = "Benutze folgendes Format '[5-9][a-z]'/'EF'/'Q[1-2]'/'Lehrer'";
    }

  if(empty($errors) == false) {
    echo "NOT_VALID";
    exit();
  }

  $update_data = array(
    'first_name'  =>  $_POST['first_name'],
    'last_name'   =>  $_POST['last_name'],
    'email'       =>  $_POST['email'],
    'class'       =>  $_POST['class'],
    'gender'      =>  $_POST['gender']
  );

  $success = update_user($GLOBALS['session_user_id'], $update_data);
  if($success === true) {
    echo "SUCCESS";
    exit();
  } else if($success === false) {
    echo "FAILURE";
    exit();
  }
}
?>
