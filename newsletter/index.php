<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Newsletter';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Newsletter';
  var page_title = 'DuisPaper - Newsletter';
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

      <div class="news">
        <h1>Newsletter</h1>
        
        <p>
          Trage im diesem Textfeld deine E-Mail-Adresse ein, um bei Änderungen der FHG News automatisch von uns benachrichtigt zu werden und nichts zu verpassen.
        </p>

        <input type="email" name="email" id="email" placeholder="max.mustermann@beispiel.de">
        <input type="submit" value="Newsletter abonnieren" id="send">

      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
