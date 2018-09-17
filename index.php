<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Startseite";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
    <title>DuisPaper</title>

    <meta name="google-site-verification" content="XXxXxxXxXxxxx-xXxXXxxXXxxXXXxXxxXxXxxXXxXxX" />

    <meta name="description" content="Startseite der Webseite DuisPaper.de • Die FHG-News ist die Schülerzeitung des Franz-Haniel-Gymnasiums (FHG).
    Auf dieser Seite gibt es viele Informationen und Zusatzinhalte." />
    <meta name="keywords" content="DuisPaper, FHG, Schülerzeitung, Franz-Haniel-Gymnasium, FHG-News, News, FHG News, Start, Startseite, Home,
    Zeitung, Online, SZ">
    <? include "$root/includes/head.php"; ?>
    <script src="/js/script.js"></script>
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

      <article class="heft">
        <div class="book_box">
          <div class="book">
            <div class="rueckseite"><div></div></div>
            <img src="/img/cover.svg" onload="imgReady()" />
            <div class="loader">
              <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10"/>
              </svg>
            </div>
            <div class="cover"></div>
          </div>
        </div>
      </article>
      <article class="buy-info">
        <div class="content">
          <h2>Verkauf:</h2>
          <div class="place">
            <img src="/img/place.svg" />
            <div class="text">
              <p>
                Franz-Haniel-Gymnasium<br />
                In der Cafetaria/Mensa
              </p>
            </div>
          </div>
          <div class="time">
            <img src="/img/clock.svg" />
            <div class="text">
              <p>
                Jeden Schultag<br />
                ab dem 21.06.2017
              </p>
            </div>
          </div>
        </div>
        <div class="bg"></div>
      </article>
      <article class="buy-price">
        <div class="content">
          <img src="/img/money.svg"/>
          <div class="price">
            <p class="nur">nur</p>
            <div class="euro">
              <p>5<br />4<br />3<br />2<br />1<br />0</p>
            </div>
            <p class="komma">,</p>
            <div class="cent">
              <p>50</p>
            </div>
            <p class="sign">€</p>
          </div>
        </div>
        <div class="bg"></div>
      </article>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
