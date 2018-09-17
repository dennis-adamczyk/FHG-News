<?

function setRememberCookie($user_id) {
  $time = time() + 1209600;
  $encoded_user_id = encodeRand($user_id);
  setcookie("user_id", $encoded_user_id, $time, '/', $_SERVER["HTTP_HOST"], false);
}

function refreshRememberCookie() {
  if($_COOKIE['user_id'] !== null) {
    $time = time() + 1209600;
    setcookie("user_id", $_COOKIE['user_id'], $time, '/', $_SERVER["HTTP_HOST"], false);
  }
}

function delRememberCookie() {
  setcookie("user_id","0", (time() - 100), '/', $_SERVER["HTTP_HOST"], false);
}



function change_password($user_id, $password) {
  $user_id = (int) $user_id;
  $password = sha1($password);

  $data = user_data($user_id, 'settings');
  $json = json_decode($data['settings'], true);
  $json['activated'] = true;
  $settings = json_encode($json);

  $query = mysqli_query($GLOBALS['mysqli'], "UPDATE `users` SET `password` = '$password', `settings` = '$settings' WHERE `ID` = $user_id");
  if($query === true) {
    return true;
  } else if($query === false) {
    return false;
  } else {
    return true;
  }
}

function user_data($user_id) {
  $data = array();
  $user_id = (int) $user_id;

  $func_num_args = func_num_args();
  $func_get_args = func_get_args();

  if($func_num_args > 1) {
    unset($func_get_args[0]);

    $fields = '`' . implode('`, `', $func_get_args) . '`';
    $query = mysqli_query($GLOBALS['mysqli'], "SELECT $fields FROM `users` WHERE `ID` = $user_id");
    $data = mysqli_fetch_array($query, MYSQLI_BOTH);

    return $data;
  }
}

function is_logged_in() {
  return isset($_SESSION['user_id']);
}

function name_by_username($username) {
  $username = sanitize($username);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT `first_name` FROM `users` WHERE `username` = '$username'");
  $name = mysqli_fetch_array($query, MYSQLI_BOTH)[0];
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT `last_name` FROM `users` WHERE `username` = '$username'");
  $name .= ' ' . mysqli_fetch_array($query, MYSQLI_BOTH)[0];
  return $name;
}

function user_id_by_username($username) {
  $username = sanitize($username);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT `ID` FROM `users` WHERE `username` = '$username'");
  return (mysqli_fetch_array($query, MYSQLI_BOTH)[0]);
}

function login($username, $password) {
  $user_id = user_id_by_username($username);

  $username = sanitize($username);
  $password = sha1($password);

  $query = mysqli_query($GLOBALS["mysqli"], "SELECT COUNT(`ID`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'");
  return (mysqli_fetch_array($query, MYSQLI_BOTH)[0] == 1) ? $user_id : false;
}

function user_exists($username) {
  $username = sanitize($username);
  $query = mysqli_query($GLOBALS["mysqli"], "SELECT * FROM `users` WHERE `username` = '$username'");
  return (is_null(mysqli_fetch_array($query, MYSQLI_BOTH)) === true) ? false : true;
}
