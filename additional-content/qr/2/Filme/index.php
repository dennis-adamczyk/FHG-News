<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Zusatzinhalte';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Zusatzinhalte';
  var page_title = 'DuisPaper - Zusatzinhalte';
  var article_title = 'Edgar Wright - Ein Meister der visuellen Comedy';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? include "$root/includes/head.php"; ?>
    <script>document.write('<title>' + page_title + '</title>');</script>
    <link rel="stylesheet" href="/additional-content/qr/css/include.css" />
    <link rel="stylesheet" href="css/page.css" />
    <script src="/additional-content/qr/js/include.js"></script>
  </head>
  <body>

    <? include "$root/includes/header.php"; ?>
    <? include "$root/includes/nav.php"; ?>

    <div class="content">
      <? include "$root/additional-content/qr/include.php"; ?>
        <p>Artikel inspiriert durch: <a href="https://youtu.be/3FOzD4Sfgag">Edgar Wright - How to Do Visual Comedy</a></p>
      <? include "$root/additional-content/qr/include_end.php"; ?>
    </div>

  </body>
</html>
