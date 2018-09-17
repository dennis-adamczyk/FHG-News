<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
$this_page = "";
loggedin_redirect();

$mode_allowed = array('email', 'password');
if(isset($_GET['mode']) && in_array($_GET['mode'], $mode_allowed)) {

} else {
  header('Location: /index.php');
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/recover.css" />
    <? include "$root/includes/head.php"; ?>
    <script src="js/recover.js"></script>
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
      <? include "$root/includes/popup.php"; ?>

      <div id="recovery">
        <h1><? echo ($_GET['mode'] == 'email') ? "E-Mail-Adresse vergessen" : "Passwort vergessen"; ?></h1>
        <form action="javascript:void(0);" method="post" class="clearfix" autocomplete="off" novalidate>
          <?
          if($_GET['mode'] == 'email') {
          ?>
          <div class="input-group">
            <input type="text" name="first_name" id="first_name" class="text-field"/>
            <label for="first_name" class="text-label">Vorname</label>
            <label for="first_name" class="error"></label>
          </div>
          <div class="input-group clearfix">
            <input type="text" name="last_name" id="last_name" class="text-field"/>
            <label for="last_name" class="text-label">Nachname</label>
            <label for="last_name" class="error"></label>
          </div>
          <?
          } else if($_GET['mode'] == 'password') {
          ?>
          <div class="input-group full-line">
            <input type="email" name="email" id="email" class="text-field"/>
            <label for="first_name" class="text-label">E-Mail</label>
            <label for="first_name" class="error"></label>
          </div>
          <?
          }
          ?>
          <div class="input-group clearfix">
            <input type="submit" id="submit" class="button clearfix" value="wiederherstellen"/>
          </div>
        </form>
      </div>
    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
