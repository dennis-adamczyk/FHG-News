<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Zusatzinhalte";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <title>Zusatzinhalte der FHG-News</title>
    <meta name="description" content="Zusatzinhalte − DuisPaper DE • Hier findest du viele Online Zusatzinhalte zu den Artikeln in der
    Schülerzeitung FHG-News (siehe QR Codes)." />
    <meta name="keywords" content="DuisPaper, FHG, Schülerzeitung, Franz-Haniel-Gymnasium, FHG-News, News, FHG News, Zusatz, Zusatzinhalte, Online,
    Inhalte, QR Codes">
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

      <h1>Zusatzinhalte</h1>
      <div class="stroke"></div>
      <p>
        In unserer Zeitung gibt es zusätzliche, interaktive Inhalte. Diese kann man erreichen, indem man die QR-Codes unter einzelnen
        Artikeln scannt. So kommt man auf die Webseite, die zu diesem Thema noch mehr Informationen und
        In&shy;ter&shy;aktions&shy;möglich&shy;keiten bietet.
      </p>
      <p>
        Das Verfahren, das wir hier einsetzen nennt man in der Fachsprache „Crossmedialität“ und bedeutet eigentlich nur, dass wir das
        Lesen der Zeitung (Print) mit der Interaktion im Internet (Web) verbinden. Wir nennen das auch gerne „Preb“ (<strong>Pr</strong>int
        W<strong>eb</strong>).
      </p>
      <p>
        Die QR-Codes könnt ihr mit eurem Smartphone scannen, indem ihr entweder eine extra QR-Code-Reader-/QR-Code-Scanner-App oder eine
        Webseite, wie zum Beispiel
        <a href="http://the-qrcode-generator.com/scan" target="_blank">www.the-<wbr>qr&shy;code-<wbr>ge&shy;ne&shy;ra&shy;tor.com/<wbr>scan</a>,
        nutzt.
      </p><p>
      <img src="img/scan.jpg" algin="top" />

        Bei den meisten Zusatzinhalten handelt es sich um Kommentarfunktionen, Umfragen, Bilder, Videos oder Audios. Bei einigen davon
        müsst ihr euch zuerst anmelden, aber das sollte kein Problem sein. Nutzt dazu einfach das Symbol oben rechts auf dieser Seite.
        Wenn ihr mehr Informationen zum Thema <a href="/impressum/#datenschutz">Datenschutz</a> für die Anmeldung erhalten möchtet, könnt
        nochmal alles im Impressum nachlesen. Bei offenen Fragen könnt ihr gerne das <a href="/contact">Kontaktformular</a> benutzen.
      </p>
      <p>
        Wenn ihr die Zeitung gelesen habt könnt ihr uns auch Feedback geben, damit wir die nächste Ausgabe der Schülerzeitung noch besser
        machen und optimieren können.
      </p>
      <p>
        Also worauf wartet ihr noch? Nehmt euer Handy in die Hand und guckt euch die Zusatzinhalte an.
      </p>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
