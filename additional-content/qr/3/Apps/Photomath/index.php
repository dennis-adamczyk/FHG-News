<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Zusatzinhalte';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Zusatzinhalte';
  var page_title = 'DuisPaper - Zusatzinhalte';
  var article_title = 'Apps - Photomath';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? include "$root/includes/head.php"; ?>
    <script>document.write('<title>' + page_title + '</title>');</script>
    <link rel="stylesheet" href="/additional-content/qr/css/include.css" />
    <script src="/additional-content/qr/js/include.js"></script>
    <script src="js/page.js"></script>
  </head>
  <body>

    <? include "$root/includes/header.php"; ?>
    <? include "$root/includes/nav.php"; ?>

    <div class="content">
      <? include "$root/additional-content/qr/include.php"; ?>

      <p>Weiterleitung...</p>

      <? include "$root/additional-content/qr/include_end.php"; ?>
    </div>

  </body>
</html>
