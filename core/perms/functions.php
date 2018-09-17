<?

$root = realpath($_SERVER["DOCUMENT_ROOT"]);
$permcontents = file_get_contents("$root/roles/permissions.json");
$perms = json_decode($permcontents, true);

function get_role_name($role) {
  global $perms;
  return $perms[$role]["name"];
}

function get_role_name_f($role) {
  global $perms;
  return $perms[$role]["f_name"];
}

function get_role_color($role) {
  global $perms;
  return $perms[$role]["color"];
}

function get_role_light_color($role) {
  global $perms;
  return $perms[$role]["light_color"];
}

function has_role_perm($role, $perm) {
  global $perms;
  $has_perm = $perms[$role]["permissions"][$perm];
  if ($has_perm === null) {
    $has_perm = false;
  }
  return $has_perm;
}

?>
