<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";
loggedin_redirect();

$this_page = "";

?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/register.css" />
    <? include "$root/includes/head.php"; ?>
    <script src="js/register.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

      <div id="register">
        <h1>Registrierung</h1>
        <form action="javascript:void(0);" method="post" autocomplete="off" novalidate>
          <div class="input-group first">
            <input type="text" name="first_name" id="first_name" class="text-field"/>
            <label for="first_name" class="text-label">Vorname*</label>
            <label for="first_name" class="error"></label>
          </div>
          <div class="input-group first">
            <input type="text" name="last_name" id="last_name" class="text-field"/>
            <label for="last_name" class="text-label">Nachname*</label>
            <label for="last_name" class="error"></label>
          </div>
          <div class="input-group full-line">
            <input type="email" name="email" id="email" class="text-field"/>
            <label for="email" class="text-label">E-Mail*</label>
            <label for="email" class="error"></label>
          </div>
          <div class="input-group second">
            <input type="text" name="class" id="class" class="text-field"/>
            <label for="class" class="text-label">Klasse/Stufe/„Lehrer“*</label>
            <label for="class" class="error"></label>
          </div>
          <div class="input-group second">
            <select name="gender" id="gender">
              <option value="" selected disabled>Bitte auswählen</option>
              <option value="f">♀ weiblich</option>
              <option value="m">♂ männlich</option>
            </select>
            <label for="gender second" class="select-label">Geschlecht*</label>
            <i class="fa fa-chevron-down" aria-hidden="true"></i>
            <label for="gender" class="error"></label>
          </div>
          <div class="input-group second">
            <input type="password" name="password1" id="password1" class="text-field"/>
            <label for="password1" class="text-label">Passwort*</label>
            <label for="password1" id="safety-text"></label>
            <label for="password1" class="error"></label>
          </div>
          <div class="input-group second">
            <input type="password" name="password2" id="password2" class="text-field"/>
            <label for="password2" class="text-label">Passwort wiederholen*</label>
            <label for="password2" class="error"></label>
          </div>
          <div class="input-group second recaptcha">
            <div class="g-recaptcha" data-sitekey="xXxxxxXXXXXXXXXxXxxXXxxxXxXXxxxxxXXxxXxx"></div>
            <label for="g-recaptcha" class="error"></label>
          </div>
          <div class="input-group second submit">
            <svg class="spinner" width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
              <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
            </svg>
            <input type="submit" name="submit" value="Registrieren" id="submit" class="button"/>
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
