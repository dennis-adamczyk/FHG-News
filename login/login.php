<?
include "../core/init.php";
loggedin_redirect();

$email = $_POST['email'];
$password = $_POST['password'];
$enter = boolval($_POST['enter']);
$remember = boolval($_POST['remember']);

$mail = explode('@', $email);
$mail = end($mail);

if(!isset($email)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($email)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($email) == 0) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(stristr($email, ' ') !== false) {
  $errors[] = "0|In diesem Feld sind keine Leerzeichen erlaubt";
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "0|Bitte gebe ihre richtige E-Mail-Adresse an";
} else if(!user_exists($email)) {
  $errors[] = "0|Diese E-Mail-Adresse wird von niemandem verwendet. <a href=\"/login/register.php\">Registrieren</a>";
} else if(user_active($email) === false) {
  $errors[] = '0|Dein Konto ist noch nicht verifiziert. <a href="http://' . $mail . '">E-Mails checken</a>';
}

if(!isset($password)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($password)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($password) == 0) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(stristr(' ', $password) !== false) {
  $errors[] = "1|In diesem Feld sind keine Leerzeichen erlaubt";
}

if(empty($errors)) {
  if($enter === true) {
    $login = login($email, $password);
    if($login === false) {
      $errors[] = '1|Das Passwort ist falsch!';
    } else {
      $_SESSION['user_id'] = $login;
      if($remember == 1) {
        setRememberCookie($login);
      }
      echo "SUCCESS";
      exit();
    }
  }
}

if(!empty($errors)) {
  foreach ($errors as $error) {
    echo $error . ";";
  }
} else {
  echo null;
}
?>
