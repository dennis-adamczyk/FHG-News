<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
protect_page();
$this_page = "";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/settings.css" />
    <? include "$root/includes/head.php"; ?>
    <script src="js/settings.js"></script>
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
      <div id="settings">
        <h1>Einstellungen</h1>
        <form action="javascript:void(0);" method="post" autocomplete="off" novalidate>
          <div class="input-group half-line">
            <input type="text" name="first_name" id="first_name" class="text-field has-value" value="<? echo $user_data['first_name']; ?>"/>
            <label for="first_name" class="text-label">Vorname</label>
            <label for="first_name" class="error"></label>
          </div>
          <div class="input-group half-line">
            <input type="text" name="last_name" id="last_name" class="text-field has-value" value="<? echo $user_data['last_name']; ?>"/>
            <label for="last_name" class="text-label">Nachname</label>
            <label for="last_name" class="error"></label>
          </div>
          <div class="input-group full-line">
            <input type="email" name="email" id="email" class="text-field has-value" value="<? echo $user_data['email']; ?>"/>
            <label for="email" class="text-label">E-Mail</label>
            <label for="email" class="error"></label>
          </div>
          <div class="input-group half-line-two">
            <input type="text" name="class" id="class" class="text-field has-value" value="<? echo $user_data['class']; ?>"/>
            <label for="class" class="text-label">Klasse/Stufe/„Lehrer“</label>
            <label for="class" class="error"></label>
          </div>
          <div class="input-group half-line-two">
            <select name="gender" id="gender" class="select">
              <option value="f" <? echo ($user_data['gender'] == 'f') ? "selected" : "" ?>>♀ weiblich</option>
              <option value="m" <? echo ($user_data['gender'] == 'm') ? "selected" : "" ?>>♂ männlich</option>
            </select>
            <label for="select" class="select-label">Geschlecht</label>
            <i class="fa fa-chevron-down" aria-hidden="true"></i>
            <label for="select" class="error"></label>
          </div>
          <div class="input-group submit">
            <input type="submit" name="submit" value="Einstellungen aktualisieren" id="submit" class="button"/>
          </div>
        </form>
      </div>
    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
