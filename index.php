<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Start';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Start';
  var page_title = 'DuisPaper - Start';
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
      <section class="sec1">
        <img src="img/1.png" data-scroll="0" class="fadeup scroll" />
        <p data-scroll="400" class="fadeup scroll">Mithilfe deiner Wünsche verbessert</p>
        <div class="scroll-down fadeup scroll" data-scroll="800"><a href="#go_content"><i class="material-icons first">keyboard_arrow_down</i><br /><i class="material-icons second">keyboard_arrow_down</i></a></div>
      </section>
      <div id="go_content"></div>
      <section class="sec2">
        <div class="presents">
          <img src="/img/logo.svg" />
          <p><span>DuisPaper</span> PRÄSENTIERT</p>
        </div>
        <div class="fhg_news">
          <img src="img/fhg_news.png" />
          <p class="ausgabe">AUSGABE <span>4</span></p>
          <p class="date">— JULI 2018 —</p>
        </div>
      </section>
      <section class="sec3">
        <p>Immer auf dem neusten Stand bleiben</p>
        <div>
          <img src="img/2.png" />
        </div>
      </section>
      <section class="sec4">
        <p>Mit festerem Papier</p>
        <div>
          <img src="img/3.png" />
        </div>
      </section>
      <section class="sec5">
        <p>Ansprechenderes Design</p>
        <img src="img/4.png" />
        <p class="description">In Zusammenarbeit mit einem <a href="http://www.rasch-multimedia.de" target="_blank">Werbe- und Komunikationsbüro aus Duisburg</a></p>
      </section>
      <section class="sec6">
        <div class="sec-content">
          <div class="logo">
            <img src="img/fhg_news.png" /><p>4</p>
          </div>
          <div class="slider">
            <div class="images" style="left: 0px;">
              <div class="image"><img src="img/1.png" style="box-shadow: 0 2px 5px rgba(0, 0, 0, .26) " /></div><div class="image"><img src="img/2.png" style="transform: translate(-50%, -50%) scale(1.1);" /></div><div class="image"><img src="img/3.png" style="transform: translate(-50%, -50%) scale(1.37);" /></div><div class="image"><img src="img/4.png" /></div>
            </div>
            <div class="navigation">
              <div class="dot first active"></div>
              <div class="dot second"></div>
              <div class="dot third"></div>
              <div class="dot fourth"></div>
            </div>
          </div>
          <div class="buy-information">
            <div class="writing">
              <p><span>Nur</span><br />0.50 €</p>
            </div>
            <div class="writing">
              <p><span>Ab dem</span><br />04. Juli 2018</p>
            </div>
            <div class="writing">
              <p><span>In jeder</span><br />20-Minuten-Pause</p>
            </div>
            <div class="writing">
              <p><span>Auf dem</span><br />Schulhof</p>
            </div>
            <div class="writing">
              <p><span>Und beim</span><br />Sommerkonzert</p>
            </div>
            <div class="buy">
              <div class="button">
                <p><i class="material-icons">shopping_cart</i> KAUFEN</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
