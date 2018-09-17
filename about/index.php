<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Ueber-uns";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <title>Über uns</title>
    <meta name="description" content="Über-Uns der Webseite DuisPaper DE • Hier stellen wir euch die kleveren Köpfe hinter der Schülerzeitung
    FHG-News des Franz-Haniel-Gymnasiums vor." />
    <meta name="keywords" content="DuisPaper, FHG, Schülerzeitung, Franz-Haniel-Gymnasium, FHG-News, News, FHG News, Über uns, About, Über">
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

      <h1>Über uns</h1>
      <div class="stroke"></div>
      <p class="text">
        Hallo,<br />
        Wir, das FHG-News-Team, wollen uns hiermit gerne Vorstellen.<br />
        Zuerst erzähle ich euch, wie wir auf die Idee gekommen sind die Schülerzeitung zu machen. An sich, gar keine spannende Geschichte:<br />
        Wir sollten im Wirtschaftsunterricht, bei Herr Junkers, eine „eigene Firma“ gründen und nach vielem hin und her geplane, haben wir uns
        dann dazu entschieden eine Schülerzeitung zu gründen. Also haben wir uns ein Konzept überlegt. Dieses war tatsächlich so überzeugend
        und realistisch, dass wir uns mit Herr Junkers zusammengesetzt haben und es jetzt einfach mal ausprobieren wollen.<br />
        Im Moment gibt es 7 Leute in unserer Redaktion, darunter 4 Autorinnen und Autoren: Johanna D. (9E), Anastasia S. (9E), Sefa K. (7E)
        und Josef A. (8E) und die Gründer: Dennis A. (8A), Paul P. (8A) und Vanessa A. (8C).<br />
        Dennis, der Chefredakteur, kümmert um diese Webseite und behält die Übersicht über alles. Der Chef-Autor ist Paul und Vanessa kümmert sich
        um die Finanzen.
      </p>
      <div class="image">
        <img src="img/redaktion.jpg" onload="imgReady()" />
        <div class="loader">
          <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/>
          </svg>
        </div>
      </div>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
