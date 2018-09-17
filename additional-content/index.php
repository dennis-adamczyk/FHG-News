<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Zusatzinhalte';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Zusatzinhalte';
  var page_title = 'DuisPaper - Zusatzinhalte';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? include "$root/includes/head.php"; ?>
    <script>document.write('<title>' + page_title + '</title>');</script>
    <link rel="stylesheet" href="css/page.css" />
    <script src="js/instascan.min.js"></script>
  </head>
  <body>

    <? include "$root/includes/header.php"; ?>
    <? include "$root/includes/nav.php"; ?>

    <div class="content">

      <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
          <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
        </svg>
      </div>

      <div class="help"><i class="material-icons">help</i></div>
      <div class="laser"><span></span></div>
      <video id="preview"></video>
      <script src="js/page.js"></script>

      <? //include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
