<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
$this_page = "";
protect_page();
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/changepassword.css" />
    <? include "$root/includes/head.php"; ?>
    <script src="js/changepassword.js"></script>
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
      <div id="cpw">
        <h1>Passwort ändern</h1>
        <form action="javascript:void(0);" method="post" autocomplete="off" novalidate>
          <div class="input-group">
            <input type="password" name="current_password" id="current_password" class="text-field"/>
            <label for="current_password" class="text-label">Aktuelles Passwort*</label>
            <label for="current_password" class="error"></label>
          </div>
          <div class="input-group">
            <input type="password" name="password1" id="password1" class="text-field"/>
            <label for="password1" class="text-label">Neues Passwort*</label>
            <label for="password1" id="safety-text"></label>
            <label for="password1" class="error"></label>
          </div>
          <div class="input-group">
            <input type="password" name="password2" id="password2" class="text-field"/>
            <label for="password2" class="text-label">Neues Passwort wiederholen*</label>
            <label for="password2" class="error"></label>
          </div>
          <div class="input-group submit">
            <input type="submit" name="submit" value="Passwort ändern" id="submit" class="button"/>
          </div>
          <div class="input-group">
            <p>* Pflichtfeld</p>
          </div>
        </form>
      </div>
    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
