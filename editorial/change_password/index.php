<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";
editorial_page($_SERVER['PHP_SELF']); ?>
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

      <div class="change_form">
        <div class="top">
          <h1>Passwort ändern</h1>
        </div>
        <div class="form">
          <? if(!isset($_GET['failure'])) { ?>
          <form action="javascript:void(0);" method="post" autocomplete="off" id="form" novalidate>
            <div class="text-field">
              <input  type="password" class="text-field_input" id="password1" name="password1" required mozactionhint="next" form="form" tabindex="1" />
              <label for="password1" class="text-field_label">Neues Passwort</label>
              <label for="password1" class="error"></label>
            </div>
            <div class="text-field">
              <input  type="password" class="text-field_input" id="password2" name="password2" required mozactionhint="next" form="form" tabindex="2" />
              <label for="password2" class="text-field_label">Neues Passwort wiederholen</label>
              <label for="password2" class="error"></label>
            </div>
            <div class="submit">
              <input type="submit" class="submit_button" id="submit" name="submit" form="form" tabindex="4" value="FERTIG" />
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
