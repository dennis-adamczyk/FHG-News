<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Hilfe';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Hilfe';
  var page_title = 'DuisPaper - Hilfe';
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

      <div class="subheader"></div>

      <div class="main">
        <h1>Willkommen in der DuisPaper-Hilfe</h1>
        <section class="favorite-article">
          <h3>Beliebte Artikel</h3>
          <ul>
            <a href="article/?nr=1"><li><i class="material-icons">assignment</i><p>QR-Code-Scanner richtig benutzen</p></li></a>
            <a href="article/?nr=2"><li><i class="material-icons">assignment</i><p>Fehler in den FHG News gefunden</p></li></a>
            <a href="article/?nr=3"><li><i class="material-icons">assignment</i><p>Fehler auf der Webseite gefunden</p></li></a>
            <a href="article/?nr=4"><li><i class="material-icons">assignment</i><p>RedakteurIn werden</p></li></a>
          </ul>
        </section>
      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
