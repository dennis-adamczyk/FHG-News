<?
function get_online_time($user_id) {
  $query = mysqli_query($GLOBALS['mysqli'], "SELECT `online` FROM `users` WHERE `user_id` = " . $user_id);
  $result = mysqli_fetch_array($query, MYSQLI_BOTH);
  return $result[0];
}

function recover($data) {
  $args = func_get_args();
  array_walk($args, 'array_sanitize');

  $mode = $args[0];

  if ($mode == 'email') {
    $user_id = user_id_by_name($args[1], $args[2]);
    $user_data = user_data($user_id, 'email');
    return $user_data['email'];
    exit();
  } else if ($mode == 'password') {
    $user_id = user_id_by_email($args[1]);
    $user_data = user_data($user_id, 'first_name');
    $password = "";
    $password = substr(sha1(rand(0, 9999)), 0, 8);
    $success = change_password($user_id, $password);
    update_user($user_id, array('password_recover' => '1'));
    email($args[1], 'Passwort-Reset', "<html><head><meta charset=\"utf-8\" /></head><body>Hallo " . $user_data['first_name'] . ",<br /><br />
Du hast auf <a href=\"http://duispaper.de\">unserer Webseite</a> die 'Passwort-vergessen'-Funktion benutzt. Dein Passwort wurde nun zurückgesetzt.<br />
Benutze das untenstehende Passwort um dich mit deiner E-Mail-Adresse anzumelden.<br />
Nachdem du dich angemeldet hast, wirst du dazu aufgefordert dein Passwort zu ändern.<br /><br />
Dein vorübergehendes Passwort: <b>" . $password . "</b><br /><br />
- Dein FHGNews-Team<br />
&copy; DuisPaper 2017<br /></body></html>");
    return $success;
  }
}

function update_user($user_id, $update_data) {
  if (isset($update_data['first_name']) && $update_data['first_name'] !== null) {
    $update_data['first_name'] = strtolower($update_data['first_name']);
    $first_name_parts = explode(' ', $update_data['first_name']);
    $first_name = array();
    foreach ($first_name_parts as $part) {
      $first_name[] = ucfirst($part);
    }
    $update_data['first_name'] = implode(' ', $first_name);
  }
  //----------------------------------------------------------------------------
  if (isset($update_data['last_name']) && $update_data['last_name'] !== null) {
    $update_data['last_name'] = strtolower($update_data['last_name']);
    $last_name_parts = explode(' ', $update_data['last_name']);
    $last_name = array();
    foreach ($last_name_parts as $part) {
      $last_name[] = ucfirst($part);
    }
    $update_data['last_name'] = implode(' ', $last_name);
  }
  //----------------------------------------------------------------------------
  if (isset($update_data['email']) && $update_data['email'] !== null) {
    $update_data['email'] = strtolower($update_data['email']);
  }
  //----------------------------------------------------------------------------
  if (isset($update_data['class']) && $update_data['class'] !== null) {
    $update_data['class'] = strtoupper($update_data['class']);
  }
  //----------------------------------------------------------------------------
  array_walk($update_data, 'array_sanitize');

  $update = array();
  foreach ($update_data as $field => $data) {
    $update[] = '`' . $field . '` = \'' . $data . '\'';
  }

  $sql = "UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` =  " . $user_id;
  $query = mysqli_query($GLOBALS['mysqli'], $sql);
  if ($query === true) {
    return true;
  } else if ($query === false) {
    return false;
  } else {
    return true;
  }
}

function activate($email, $email_code) {
  $email = sanitize($email);
  $email_code = sanitize($email_code);

  $sql = "SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0";
  $query = mysqli_query($GLOBALS['mysqli'], $sql);
  $result = mysqli_fetch_array($query, MYSQLI_BOTH);

  if ($result[0] == '0') {
    return false;
  } else {
    $query = mysqli_query($GLOBALS['mysqli'], "UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
    if ($query == false) {
      return false;
    } else {
      return true;
    }
  }
}

function change_password($user_id, $password) {
  $user_id = (int)$user_id;
  $password = sha1($password);

  $query = mysqli_query($GLOBALS['mysqli'], "UPDATE `users` SET `password` = '$password', `password_recover` = 0 WHERE `user_id` = $user_id");
  if ($query === true) {
    return true;
  } else if ($query === false) {
    return false;
  } else {
    return true;
  }
}

function register_user($register_data) {
  $register_data['first_name'] = strtolower($register_data['first_name']);
  $first_name_parts = explode(' ', $register_data['first_name']);
  $first_name = array();
  foreach ($first_name_parts as $part) {
    $first_name[] = ucfirst($part);
  }
  $register_data['first_name'] = implode(' ', $first_name);
  //----------------------------------------------------------------------------
  $register_data['last_name'] = strtolower($register_data['last_name']);
  $last_name_parts = explode(' ', $register_data['last_name']);
  $last_name = array();
  foreach ($last_name_parts as $part) {
    $last_name[] = ucfirst($part);
  }
  $register_data['last_name'] = implode(' ', $last_name);
  //----------------------------------------------------------------------------
  $register_data['email'] = strtolower($register_data['email']);
  //----------------------------------------------------------------------------
  $register_data['class'] = strtoupper($register_data['class']);
  //----------------------------------------------------------------------------
  array_walk($register_data, 'array_sanitize');
  $register_data['password'] = sha1($register_data['password']);

  $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
  $data = '\'' . implode('\', \'', $register_data) . '\'';

  $query = mysqli_query($GLOBALS['mysqli'], "INSERT INTO `users` ($fields) VALUES ($data)");
  email($register_data['email'], 'Aktiviere deinen Account', "<html><head><meta charset=\"utf-8\" /></head><body>Hallo " . $register_data['first_name'] . ",<br /><br />
Du musst deinen Account aktivieren. Benutze dazu einfach den folgenden Link:<br />
<a href=\"http://duispaper.de/login/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "\">http://duispaper.de/login/activate.php?email=" . $register_data['email'] . "&email_code=" . $register_data['email_code'] . "</a><br /><br />
- Dein FHGNews-Team<br />
&copy; DuisPaper 2017<br /></body></html>");
  if ($query === true) {
    return true;
  } else if ($query === false) {
    return false;
  } else {
    return true;
  }
}

function user_count() {
  $query = mysqli_query($GLOBALS['mysqli'], "SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1");
  $result = mysqli_fetch_array($query, MYSQLI_BOTH);
  return $result[0];
}

function user_data($user_id) {
  $data = array();
  $user_id = (int)$user_id;

  $func_num_args = func_num_args();
  $func_get_args = func_get_args();

  if ($func_num_args > 1) {
    unset($func_get_args[0]);

    $fields = '`' . implode('`, `', $func_get_args) . '`';
    $query = mysqli_query($GLOBALS['mysqli'], "SELECT $fields FROM `users` WHERE `user_id` = $user_id");
    $data = mysqli_fetch_array($query, MYSQLI_BOTH);

    return $data;
  }
}

function is_logged_in() {
  return isset($_SESSION['user_id']);
}

function user_exists($email) {
  $email = sanitize($email);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT * FROM `users` WHERE `email` = '$email'");
  return (is_null(mysqli_fetch_array($query, MYSQLI_BOTH)) === true) ? false : true;
}

function name_exists($first_name, $last_name) {
  $first_name = sanitize($first_name);
  $last_name = sanitize($last_name);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT * FROM `users` WHERE `first_name` = '$first_name' AND `last_name` = '$last_name'");
  return (is_null(mysqli_fetch_array($query, MYSQLI_BOTH)) === true) ? false : true;
}

function user_active($email) {
  $email = sanitize($email);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT * FROM `users` WHERE `email` = '$email' AND `active` = 1");
  return (is_null(mysqli_fetch_array($query, MYSQLI_BOTH)) === true) ? false : true;
}

function user_id_by_email($email) {
  $email = sanitize($email);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT `user_id` FROM `users` WHERE `email` = '$email'");
  return (mysqli_fetch_array($query, MYSQLI_BOTH)[0]);
}

function user_id_by_name($first_name, $last_name) {
  $first_name = sanitize($first_name);
  $last_name = sanitize($last_name);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT `user_id` FROM `users` WHERE `first_name` = '$first_name' AND `last_name` = '$last_name'");
  $result = mysqli_fetch_array($query, MYSQLI_NUM);
  return $result[0];
}

function login($email, $password) {
  $user_id = user_id_by_email($email);

  $email = sanitize($email);
  $password = sha1($password);

  $query = mysqli_query($GLOBALS["mysqli"], "SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `password` = '$password'");
  return (mysqli_fetch_array($query, MYSQLI_BOTH)[0] == 1) ? $user_id : false;
}

?>
