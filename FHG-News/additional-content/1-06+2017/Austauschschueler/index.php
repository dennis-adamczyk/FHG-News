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

      <h1>Austauschschüler</h1>
      <p>
        Hier findest du das komplette Interview mit dem Austauschschüler. Klicke einfach auf das Video und guck dir das
        Video an.
      </p>
      <iframe width="560" height="315" src="https://www.youtube.com/embed/MZ3Ihmc5btg?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
