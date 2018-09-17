<?

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$errors = array();

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$email = trim($_POST['email']);
$class = trim($_POST['class']);
$gender = $_POST['gender'];
$pw1 = $_POST['password1'];
$pw2 = $_POST['password2'];

if(!isset($first_name)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($first_name)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($first_name) == 0) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(!ctype_alpha(str_replace(' ', '', $first_name))) {
  if(strpos($first_name, '-') === false) {
    $errors[] = "0|In diesem Feld sind nur Buchstaben erlaubt";
  }
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

if(!isset($email)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($email)) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($email) == 0) {
  $errors[] = "2|Dieses Feld ist ein Pflichtfeld";
} else if(stristr($email, ' ') !== false) {
  $errors[] = "2|In diesem Feld sind keine Leerzeichen erlaubt";
} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "2|Bitte gebe eine gültige E-Mail-Adresse an";
} else if(user_exists($email) === true) {
  $errors[] = "2|Diese E-Mail-Adresse wird bereits verwendet";
}

if(!isset($class)) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($class)) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($class) == 0) {
  $errors[] = "3|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($class) == 2) {
  if(ctype_digit(substr($class, 0, 1))) {
    if((int) substr($class, 0, 1) >= 5 && (int) substr($class, 0, 1) <= 9) {
      if(ctype_alpha(substr($class, 1, 1))) {
        //ERFOLGREICH
      } else {
        $errors[] = "3|Benutze folgendes Format '[5-9][a-z]'";
      }
    } else {
      $errors[] = "3|Benutze folgendes Format '[5-9][a-z]'";
    }
  } else if(strtoupper($class) == "EF" || strtoupper($class) == "Q1" || strtoupper($class) == "Q2") {
    //ERFOLGREICH
  } else {
    $errors[] = "3|Benutze folgendes Format '[5-9][a-z]'/'EF'/'Q[1-2]'";
  }
} else if(strtoupper($class) == "LEHRER") {
  //ERFOLGREICH
} else {
  $errors[] = "3|Benutze folgendes Format '[5-9][a-z]'/'EF'/'Q[1-2]'/'Lehrer'";
}

if(!isset($gender) || $gender === "" || is_null($gender)) {
  $errors[] = "4|Dieses Feld ist ein Pflichtfeld";
}

if(!isset($pw1)) {
  $errors[] = "5|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($pw1)) {
  $errors[] = "5|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($pw1) == 0) {
  $errors[] = "5|Dieses Feld ist ein Pflichtfeld";
} else if(stristr($pw1, ' ') !== false) {
  $errors[] = "5|In diesem Feld sind keine Leerzeichen erlaubt";
} else if($_POST['safe'] <= 1) {
  $errors[] = "5|Die Sicherheit muss mind. ausreichend sein";
}

if(!isset($pw2)) {
  $errors[] = "6|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($pw2)) {
  $errors[] = "6|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($pw2) == 0) {
  $errors[] = "6|Dieses Feld ist ein Pflichtfeld";
} else if(stristr($pw2, ' ') !== false) {
  $errors[] = "6|In diesem Feld sind keine Leerzeichen erlaubt";
} else if($pw2 !== $pw1) {
  $errors[] = "6|Die Passwörter stimmen nicht überein";
}

$recaptcha = checkReCaptcha();

if($recaptcha !== true) {
  if($recaptcha === false) {
    $errors[] = "7|Es ist ein unerwarteter Fehler aufgetretren";
  } else {
    $errors[] = "7|Dieses Feld ist ein Pflichtfeld";
  }
}

foreach ($errors as $error) {
  echo $error . ";";
}


function checkReCaptcha() {
  $curl = curl_init();

  curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "https://www.google.com/recaptcha/api/siteverify",
    CURLOPT_POST => 1,
    CURLOPT_POSTFIELDS => [
      'secret' => 'xXxxxxXXXXXXXXXxxXxxxXxxXXXxxxXxxXXxxxXX',
      'response' => $_POST['g_recaptcha_response'],
    ],
  ]);

  $response = json_decode(curl_exec($curl));

  if($response == false) return false;

  if(!$response->success) {
    return $result["error-codes"];
  } else {
    return true;
  }
}


if(empty($errors)) {
  $register_data = array(
    'first_name'  =>  $first_name,
    'last_name'   =>  $last_name,
    'email'       =>  $email,
    'class'       =>  $class,
    'gender'      =>  $gender,
    'password'    =>  $pw1,
    'email_code'  =>  md5($email . microtime())
  );

  $email_parts = explode("@", $email);
  $mail = "";
  foreach ($email_parts as $part) {
    $mail = $part;
  }

  $success = register_user($register_data);
  if($success) {
    echo "SUCCESS|$mail";
  } else {
    echo "FAILURE";
  }
  exit();
}

?>
