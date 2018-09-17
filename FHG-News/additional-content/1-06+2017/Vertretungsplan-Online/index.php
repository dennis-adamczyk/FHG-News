<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Zusatzinhalte";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
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

      <h1>Vertretungsplan Online?</h1>
      <p>
        In diesem Bereich der Webseite kannst du mitdiskutieren. Bist du für oder gegen die Einführung eines
        Online-Vertretungsplans? Schreib deine Meinung unten in das Diskussionsfeld.
      </p>

      <script>

      </script>

      <div class="write">
        <p>Ich</p>
        <textarea onkeyup="CheckTextAreaHeight(this)" rows="1" id="comment_input" <? echo(($session_user_id == null) ? 'placeholder="Du musst dich zuerst anmelden" disabled' : 'placeholder="Kommentar schreiben..."'); ?> ></textarea>
        <img src="img/send.svg" />
      </div>
      <div class="diskussion">
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
