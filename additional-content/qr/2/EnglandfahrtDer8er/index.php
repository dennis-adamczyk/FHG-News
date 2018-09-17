<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Zusatzinhalte';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Zusatzinhalte';
  var page_title = 'DuisPaper - Zusatzinhalte';
  var article_title = 'Englandfahrt der 8er';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? include "$root/includes/head.php"; ?>
    <script>document.write('<title>' + page_title + '</title>');</script>
    <link rel="stylesheet" href="/additional-content/qr/css/include.css" />
    <link rel="stylesheet" href="css/page.css" />
    <script src="/additional-content/qr/js/include.js"></script>
    <script src="js/page.js"></script>
  </head>
  <body>

    <? include "$root/includes/header.php"; ?>
    <? include "$root/includes/nav.php"; ?>

    <div class="content">
      <? include "$root/additional-content/qr/include.php"; ?>

      <div class="image-container">
      </div>

      <? include "$root/additional-content/qr/include_end.php"; ?>
      <? $lightbox = $_GET['lightbox'];
      if(isset($lightbox)) { ?>

      <div class="lightbox">
        <div class="header">
          <p class="img-count"><? echo($lightbox); ?> / </p>
          <div class="download"><i class="material-icons">file_download</i></div>
          <div class="close"><i class="material-icons">close</i></div>
        </div>
        <div class="img-preview">
          <? if(substr($lightbox, 0, 1) === "v") {
            echo('<video controls><source src="img/' . $lightbox . '.mp4" type="video/mp4"></video>');
          } else {
            echo('<img src="img/' . $lightbox . '.jpeg">');
          } ?>
          <div class="prev"><i class="material-icons">arrow_back</i></div>
          <div class="next"><i class="material-icons">arrow_forward</i></div>
        </div>
      </div>

      <? } ?>
    </div>

  </body>
</html>
