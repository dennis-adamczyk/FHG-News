<?

function contact($name, $email, $subject, $message) {
  $header = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $header .= 'From: ' . $name . ' <no-reply@duispaper.de>' . "\r\n";
  $header .= 'Reply-To: ' . $email . "\r\n";
  $message = sanitize($message);
  $body = "Kontaktdaten:<br />Name: '" . $name . "'<br />E-Mail: '" . $email . "'<br /><br />Betreff: '" . $subject . "'<br /><br />
Nachricht:<br />" . str_replace('\n', '<br />', $message);
  $mail = mail('support@duispaper.de', $subject, $body, $header); //TODO Aendern der ersten Email Adresse (to)*/
  return $mail;
}

function setRememberCookie($user_id) {
  $time = time() + 1209600;
  $encoded_user_id = encodeRand($user_id);
  setcookie("user_id", $encoded_user_id, $time, '/', $_SERVER["HTTP_HOST"], false);
}

function refreshRememberCookie() {
  if ($_COOKIE['user_id'] !== null) {
    $time = time() + 1209600;
    setcookie("user_id", $_COOKIE['user_id'], $time, '/', $_SERVER["HTTP_HOST"], false);
  }
}

function delRememberCookie() {
  setcookie("user_id", "0", (time() - 100), '/', $_SERVER["HTTP_HOST"], false);
}

function encodeRand($str, $seed = 6322763) {
  mt_srand($seed);
  $out = array();
  for ($x = 0, $l = strlen($str); $x < $l; $x++) {
    $out[$x] = (ord($str[$x]) * 3) + mt_rand(350, 16000);
  }

  mt_srand();
  return implode('-', $out);
}

function decodeRand($str, $seed = 6322763) {
  mt_srand($seed);
  $blocks = explode('-', $str);
  $out = array();
  foreach ($blocks as $block) {
    $ord = (intval($block) - mt_rand(350, 16000)) / 3;
    $out[] = chr($ord);
  }

  mt_srand();
  return implode('', $out);
}

function email($to, $subject, $body) {
  $header = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $header .= 'From: DuisPaper <noreply@duispaper.de>' . "\r\n";
  $header .= 'Reply-To: noreply@duispaper.de' . "\r\n";
  mail($to, $subject, $body, $header);
}

function loggedin_redirect() {
  if (is_logged_in() === true) {
    header('Location: /index.php?popup=loggedin_redirect');
    exit();
  }
}

function protect_page() {
  if (is_logged_in() === false) {
    header("Location: /index.php?popup=protected_page");
    exit();
  }
}

function array_sanitize(&$item) {
  $item = htmlentities(strip_tags(mysqli_real_escape_string($GLOBALS['mysqli'], $item)));
}

function sanitize($data) {
  return htmlentities(strip_tags(mysqli_real_escape_string($GLOBALS['mysqli'], $data)));
}

function output_errors($errors) {
  $output = array();
  foreach ($errors as $error) {
    $output[] = '<li>' . $error . '</li>';
  }
  return '<ul>' . implode('', $output) . '</ul>';
}

?>
