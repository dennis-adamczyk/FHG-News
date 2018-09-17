<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
$this_page = "";

$found = false;

if(isset($_GET['name']) === true && empty($_GET['name']) === false) {
  $name = $_GET['name'];
  $parts = explode("-", $name);
  $first_name = str_replace("_", " ", $parts[0]);
  $last_name = str_replace("_", " ", $parts[1]);

  if (name_exists($first_name, $last_name) === true) {
    $profile_user_id = user_id_by_name($first_name, $last_name);
    $profile_data = user_data($profile_user_id, 'first_name', 'last_name', 'class', 'email', 'profile_pic', 'role', 'online', 'official',
      'gender');
    $found = true;
  } else {
    $found = false;
  }
} else {
  header('Location: /index.php');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <? include "$root/includes/head.php"; ?>
    <script>
    var ONLINE = <? echo(get_online_time($profile_user_id)); ?>;
    var PROFILE_USER_ID = <? echo($profile_user_id); ?>;
    </script>
    <script src="js/profile.js"></script>
    <script>
      $(document).ready(function() {
        $('div#content div#profile .basic-info .role').css('color', '<? echo get_role_color($profile_data['role']); ?>');
        $('div#content div#profile .basic-info .pic').css('border-color', '<? echo get_role_light_color($profile_data['role']); ?>');
        $('div#content div#profile .basic-info').css('background-color', '<? echo get_role_color($profile_data['role']); ?>');
      });
    </script>
    <script src="js/profile-pic.js"></script>
  </head>
  <body>

    <noscript><? include "$root/includes/noscript.php"; ?></noscript>

    <header>
      <? include "$root/includes/header.php"; ?>
    </header>

    <aside id="sidebar">
      <? include "$root/includes/sidebar.php"; ?>
    </aside>

    <div id="content">
      <? include "$root/includes/popup.php";
      if($found == true) { ?>
      <div id="profile">
      <?
        if($profile_user_id === $session_user_id) {
          ?>

          <div class="basic-info">
            <div class="pic"><img src="/img/no-image.svg" alt="Profilbild" /></div>
            <div class="name">
              <p class="first_name"><? echo $profile_data['first_name']; ?></p>
              <p class="last_name"><? echo $profile_data['last_name']; ?></p>
            </div>
            <div class="role">
              <p><?
              if(strtolower($profile_data['gender']) == "m") {
                echo(get_role_name($profile_data['role']));
              } else {
                echo(get_role_name_f($profile_data['role']));
              }?>
            </p>
            </div>
          </div>
          <div class="extra-info clearfix">
            <div class="titles clearfix">
              <p>Klasse</p>
              <p>Geschlecht</p>
              <p>E-Mail-Adresse</p>
            </div>
            <div class="data clearfix">
              <p><? echo(($profile_data['class'] == "LEH") ? "Lehrer" : $profile_data['class']); ?></p>
              <p><? echo( ($profile_data['gender'] == 'm') ? "Männlich" : "Weiblich" ); ?></p>
              <p class="email"><? echo($profile_data['email']); ?></p>
            </div>
          </div>
          <div class="activities">

          </div>
          <div class="profile-pic-options-overlay"></div>
          <div class="profile-pic-options">
            <p>Profilbild</p>
            <div class="action-set upload">
              <div class="icon">
                <img src="/user/img/upload.svg" />
              </div>
              <p>Bild hochladen</p>
            </div>
            <div class="action-set delete">
              <div class="icon">
                <img src="/user/img/delete.svg" />
              </div>
              <p>Bild entfernen</p>
            </div>
          </div>
          <?
        } else {
          ?>

          <div class="basic-info">
            <div class="pic"><img src="/img/no-image.svg" alt="Profilbild" /><div class="online"></div></div>
            <div class="name">
              <p class="first_name"><? echo $profile_data['first_name']; ?></p>
              <p class="last_name"><? echo $profile_data['last_name']; ?></p>
            </div>
            <div class="role">
              <p><? echo(($profile_data['gender'] == "m") ? get_role_name($profile_data['role']) : get_role_name_f($profile_data['role'])); ?></p>
            </div>
          </div>
          <div class="extra-info clearfix">
            <div class="titles clearfix">
              <p>Klasse</p>
              <p>Geschlecht</p>
              <p>E-Mail-Adresse</p>
            </div>
            <div class="data clearfix">
              <p><? echo(($profile_data['class'] == "LEH") ? "Lehrer" : $profile_data['class']); ?></p>
              <p><? echo( ($profile_data['gender'] == 'm') ? "Männlich" : "Weiblich" ); ?></p>
              <p class="email"><? echo($profile_data['email']); ?></p>
            </div>
          </div>
          <div class="activities">

          </div>

          <?
        }
        ?>
      </div> <!-- END PROFILE -->
        <?
      } else {
        ?>

        <div class="error-div">
          <div class="image">
            <img src="/img/no-profile.svg" />
          </div>
          <div class="msg">
            <p>
              Dieser Benutzer existiert nicht!
            </p>
          </div>
        </div>

        <?
      }
      ?>
    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
