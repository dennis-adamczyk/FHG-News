<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php";
editorial_page($_SERVER['PHP_SELF']); ?>
<script>
  var short_title = 'OrgaPlan';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Redaktion <i class="material-icons">keyboard_arrow_right</i> OrgaPlan';
  var page_title = 'DuisPaper - Redaktion > OrgaPlan';
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

      <div class="toast"><p>Funktion zurzeit noch nicht verfügbar.</p></div>

      <div class="main">
        <h1 class="title">FHG News 3/2018</h1>
        <p class="information">Erscheinen: 15.01.2018, Druck: 05.01.2018, Redaktionsschluss: 15.12.2017, Auflage: 300<br />Umfang: 32 Seiten</p>

        <div class="plan">
          <div class="top">
            <h2>OrgaPlan</h2>
            <i class="material-icons download" title="Offline-Download">file_download</i>
            <i class="material-icons print" title="Drucken">print</i>
          </div>
          <div class="table">
            <table>
              <thead>
                <tr>
                  <th>Titel</th>
                  <th>Länge</th>
                  <th>Autor</th>
                  <th>Bearbeitungsvermerk</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>

      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
