<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Fehler melden';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Fehler melden';
  var page_title = 'DuisPaper - Fehler melden';
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

      <? if(!isset($_GET['success']) && !isset($_GET['failure'])) { ?>
      <div class="floating-button">
        <i class="material-icons">send</i>
      </div>

      <? } ?>

      <div class="main">

      <? if(!isset($_GET['success']) && !isset($_GET['failure'])) { ?>
        <h1>Sagen Sie uns, was los ist</h1>
        <form action="javascript:void(0);" method="post" autocomplete="off" id="bug_form" novalidate>
          <div class="text-field small left">
            <input  type="text" class="text-field_input" id="first-name" name="first-name" required mozactionhint="next" form="bug_form" tabindex="1" />
            <label for="first-name" class="text-field_label">Vorname</label>
            <label for="first-name" class="error"></label>
          </div><div class="text-field small right">
            <input  type="text" class="text-field_input" id="last-name" name="last-name" required mozactionhint="next" form="bug_form" tabindex="2" />
            <label for="last-name" class="text-field_label">Nachname</label>
            <label for="last-name" class="error"></label>
          </div>
          <div class="text-field">
            <input  type="email" class="text-field_input" id="email" name="email" required mozactionhint="next" form="bug_form" tabindex="3" />
            <label for="email" class="text-field_label">E-Mail</label>
            <label for="email" class="error"></label>
          </div>
          <div class="text-field">
            <input  type="text" class="text-field_input" id="url" name="url" mozactionhint="next" form="bug_form" tabindex="4" />
            <label for="url" class="text-field_label">URL</label>
            <label for="url" class="error"></label>
          </div>
          <div class="text-field">
            <textarea class="text-field_input" id="msg" name="msg" required mozactionhint="next" form="bug_form" tabindex="5"></textarea>
            <label for="msg" class="text-field_label">Beschreibung des Fehlers</label>
            <label for="msg" class="error" style="bottom: 4px;"></label>
          </div>
          <!--<div class="text-field" style="margin-top: 0;">
            <input  type="file" multiple accept="image/*, video/*, .txt, .doc, .docx" class="text-field_input" id="file" name="file" mozactionhint="send" form="bug_form" tabindex="6" />
            <label for="file" class="text-field_label">Datei anhängen</label>
            <label for="file" class="error"></label>
          </div>-->
        </form>
        <p class="info">* Pflichtfeld</p>

      <? } elseif(isset($_GET['success'])) { ?>
        <h1>Fehler gemeldet</h1>

        <div class="done"><i class="material-icons">done</i></div>
        <h2>Vielen Dank. Der Fehlerbericht wurde erfolgreich an uns übermittelt.</h2>
        <p class="subtitle">Wir werden uns innerhalb von 3 Werktagen bei Ihnen melden</p>

      <? } elseif(isset($_GET['failure'])) { ?>
        <h1>Fehlermeldung</h1>

        <div class="error"><i class="material-icons">error</i></div>
        <h2>Es ist leider ein Fehler aufgetreten</h2>
        <p class="subtitle">Bitte versuchen Sie das Formular <a href="./index.php">hier</a> erneut zu versenden. Wenn Sie möchten, können Sie uns auch direkt über unsere <a href="mailto:duispaper@outlook.de">E-Mail</a> erreichen.</p>

      <? } ?>
      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
