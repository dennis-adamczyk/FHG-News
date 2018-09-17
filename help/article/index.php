<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";

$nr_range = '4';
$nr = null;

if(!isset($_GET['nr'])) {
  header('Location: /error/404.php');
} else if(intval($_GET['nr']) > $nr_range) {
  header('Location: /error/404.php');
} else {
  $nr = $_GET['nr'];
} ?>
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
        <? include("text/" . $nr . ".php"); ?>
      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
