<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Kontakt";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <title>Kontaktformular</title>
    <meta name="description" content="Kontaktformular der Webseite DuisPaper.de • Egal ob es sich dabei um Rechtliches, Persönliches oder
    Technisches geht.
    ✔ 24/7 Support ✔ innerhalb 12h" />
    <meta name="keywords" content="DuisPaper, FHG, Schülerzeitung, Franz-Haniel-Gymnasium, FHG-News, News, FHG News, Kontakt">
    <? include "$root/includes/head.php"; ?>
    <script src="js/script.js"></script>
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

      <h1>Kontakt</h1>
      <form action="javascript:void(0);" method="post" autocomplete="off" novalidate>
        <div class="input-group">
          <input type="text" name="name" id="name" class="text-field" value="<? echo(($user_data == null) ? "" : $user_data['first_name'] . " " . $user_data['last_name']); ?>"/>
          <label for="name" class="text-label">Name</label>
          <label for="name" class="error"></label>
        </div>
        <div class="input-group">
          <input type="email" name="email" id="email" class="text-field" value="<? echo(($user_data == null) ? "" : $user_data['email']); ?>"/>
          <label for="email" class="text-label">E-Mail-Adresse</label>
          <label for="email" class="error"></label>
        </div>
        <div class="input-group">
          <input type="text" name="subject" id="subject" class="text-field"/>
          <label for="subject" class="text-label">Betreff</label>
          <label for="subject" class="error"></label>
        </div>
        <div class="input-group">
          <textarea name="message" id="message" class="text-field"/></textarea>
          <label for="message" class="text-label">Nachricht</label>
          <label for="message" class="error"></label>
        </div>
        <div class="input-group submit clearfix">
          <input type="submit" name="submit" value="senden" id="submit" class="button clearfix"/>
        </div>
      </form>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
