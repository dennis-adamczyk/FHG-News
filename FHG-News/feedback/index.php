<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Feedback";
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

      <h1>Feedback</h1>
      <div class="stroke"></div>
      <p class="text">
        Klicke jetzt auf LOS um uns Feedback für unserer Schülerzeitung und die dazugehörige Webseite zu geben. Es werden dir nacheinander
        neun Bewertungsbereiche angezeigt, zu denen du eine Bewertung in Form von maximal fünf Sternen geben kannst. Wenn du uns zum Beispiel
        Verbesserungsvorschläge usw. zu einem Bewertungsbereich geben möchtest kannst du immer auf das Symbol unter den Sternen klicken.
      </p>
      <p class="text">
        Durch dein Feedback hilfst du uns sehr die Schülerzeitung und diese Webseite zu ver&shy;bes&shy;sern.
      </p>

      <div class="steps">
        <p>
          LOS <img src="img/arrow_start.svg" />
        </p>
      </div>
      <div class="ripple"></div>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
