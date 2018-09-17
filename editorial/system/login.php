<?

$root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";

$errors = array();

$username = strtolower(trim($_POST['username']));
$password = trim($_POST['password']);
$remember = boolval($_POST['remember']);
$enter = boolval($_POST['enter']);

if(!isset($username)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($username)) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($username) < 3) {
  $errors[] = "0|Dieses Feld ist ein Pflichtfeld";
} else if(!user_exists($username)) {
  $errors[] = "0|Dieser Benutzername existiert nicht";
}

if(!isset($password)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(ctype_space($password)) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
} else if(strlen($password) < 1) {
  $errors[] = "1|Dieses Feld ist ein Pflichtfeld";
}

foreach ($errors as $error) {
  echo $error . ";";
}

if(empty($errors)) {
  if($enter === true) {
    $login = login($username, $password);
    if($login === false) {
      echo "1|Das angegebene Password ist falsch;";
    } else {
      $_SESSION['user_id'] = $login;
      if($remember == true) {
        setRememberCookie($login);
      }
      $data = user_data($login, 'settings');
      $json = json_decode($data['settings'], true);
      if($json['activated'] === false) {
        echo "ACTIVATE";
      } else {
        echo "SUCCESS";
      }
    }
  } else {
    echo " ";
    exit();
  }
}
