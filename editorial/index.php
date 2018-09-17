<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";
loggedin_redirect(); ?>
<script>
  var short_title = 'Redaktion';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Redaktion';
  var page_title = 'DuisPaper - Redaktion';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? include "$root/includes/head.php"; ?>
    <script>document.write('<title>' + page_title + '</title>');</script>
    <link rel="stylesheet" href="css/page.css" />
    <script src="js/page.js"></script>
  </head>
  <body>

    <? include "$root/includes/header.php"; ?>
    <? include "$root/includes/nav.php"; ?>

    <div class="content">

      <div class="login_form">
        <div class="top">
          <h1>Login</h1>
        </div>
        <div class="form">
          <? if(!isset($_GET['failure'])) { ?>
          <form action="javascript:void(0);" method="post" autocomplete="off" id="form" novalidate>
            <div class="text-field">
              <input  type="text" class="text-field_input" id="username" name="username" required mozactionhint="next" autocapitalize="none" form="form" tabindex="1" />
              <label for="username" class="text-field_label">Benutzername</label>
              <label for="username" class="error"></label>
            </div>
            <div class="text-field">
              <input  type="password" class="text-field_input" id="password" name="password" required mozactionhint="next" form="form" tabindex="2" />
              <label for="password" class="text-field_label">Passwort</label>
              <label for="password" class="error"></label>
            </div>
            <div class="check-field">
              <label for="remember" class="check-field_overlabel">
                <input type="checkbox" class="check-field_input" id="remember" name="remember" form="form" tabindex="3" />
                <span class="check-field_label">Angemeldet bleiben</span>
              </label>
            </div>
            <div class="submit">
              <input type="submit" class="submit_button" id="submit" name="submit" form="form" tabindex="4" value="LOGIN" />
            </div>
          </form>
        <? } else { ?>
          <div class="error"><i class="material-icons">error</i></div>
          <h2>Es ist leider ein Fehler aufgetreten</h2>
          <p class="subtitle">Bitte versuche es später erneut oder melde den Fehler</p>
        <? } ?>
        </div>
      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
