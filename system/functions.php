<?

function encodeRand($str, $seed=6322763) {
  mt_srand($seed);
  $out = array();
  for ($x=0, $l=strlen($str); $x<$l; $x++) {
    $out[$x] = (ord($str[$x]) * 3) + mt_rand(350, 16000);
  }

  mt_srand();
  return implode('-', $out);
}

function decodeRand($str, $seed=6322763) {
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


function loggedin_redirect() {
  if(is_logged_in() === true) {
    header('Location: /editorial/OrgaPlan/');
    exit();
  }
}

function editorial_page($page) {
  if(is_logged_in() === false) {
    header("Location: /editorial/?page=" . $page);
    exit();
  }
}

function contact($first_name, $last_name, $email, $subject, $message) {
  $header  = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $header .= 'From: ' . $name . ' <no-reply@duispaper.de>' . "\r\n";
  $header .= 'Reply-To: ' . $email . "\r\n";
  $message = sanitize($message);
  $body = "Kontaktformular<br />Kontaktdaten:<br />Name: '" . $first_name . ", " . $last_name . "'<br />E-Mail: '" . $email . "'<br /><br />Betreff: '" . $subject . "'<br /><br />
Nachricht:<br />" . str_replace('\n', '<br />', $message);
  $mail = mail('support@duispaper.de', $subject, $body, $header);
  return $mail;
}

function bugReport($first_name, $last_name, $email, $url, $message) {
  $header  = 'MIME-Version: 1.0' . "\r\n";
  $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
  $header .= 'From: ' . $name . ' <no-reply@duispaper.de>' . "\r\n";
  $header .= 'Reply-To: ' . $email . "\r\n";
  $message = sanitize($message);
  $body = "Fehler melden<br />Kontaktdaten:<br />Name: '" . $first_name . ", " . $last_name . "'<br />E-Mail: '" . $email . "'<br /><br />URL: '" . $url . "'<br /><br />
Nachricht:<br />" . str_replace('\n', '<br />', $message);
  $mail = mail('support@duispaper.de', "Bug Report von " . $first_name . " " . $last_name, $body, $header);
  return $mail;
}

function sanitize($data) {
  return htmlentities(strip_tags(mysqli_real_escape_string($GLOBALS['mysqli'], $data)));
}
