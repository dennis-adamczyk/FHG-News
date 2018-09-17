<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Error';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Error';
  var page_title = 'DuisPaper - Fehler 403';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? //include "$root/includes/head.php"; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script>document.write('<title>' + page_title + '</title>');</script>
    <style type="text/css">

    .main-content {
      position: fixed;
      top: 50%;
      left: 0;
      right: 0;
      transform: translateY(-50%);
      width: 100%;
    }

    .main-content i {
      position: relative;
      font-size: 64px;
      color: #757575;
      text-align: center;
      margin: 0 auto;
      left: 50%;
      transform: translateX(-50%);
    }

    .main-content h3 {
      position: relative;
      font-size: 16px;
      font-weight: 500;
      text-align: center;
      margin: 20px 0 2px 0;
      color: #212121;
      font-family: 'Roboto', sans-serif;
    }

    .main-content p {
      position: relative;
      font-size: 16px;
      font-weight: 400;
      text-align: center;
      margin: 0 0 0 0;
      color: #212121;
      font-family: 'Roboto', sans-serif;
    }

    .back {
      position: fixed;
      left: 32px;
      top: 32px;
      cursor: pointer;
      color: #616161;
    }

    </style>
  </head>
  <body>

    <i class="material-icons back" onclick="history.back()">arrow_back</i>

    <div class="main-content">
      <i class="material-icons">error</i>
      <h3>Uppsss!</h3>
      <p>Fehler 403. Verboten</p>
    </div>

  </body>
</html>
