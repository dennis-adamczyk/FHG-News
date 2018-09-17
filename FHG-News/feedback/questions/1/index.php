<?
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include "$root/core/init.php";

$this_page = "Feedback";
?>
<!DOCTYPE html>
<html>
  <head>
    <link type="text/css" rel="stylesheet" href="css/style.css" />
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

      <div class="questionrating">
        <h1>Richtigkeit der Artikel</h1>
        <div class="rating">
          <img src="../../img/unfilled_star.svg" class="p1" /><img src="../../img/unfilled_star.svg" class="p2" /><img src="../../img/unfilled_star.svg" class="p3" /><img src="../../img/unfilled_star.svg"  class="p4" /><img src="../../img/unfilled_star.svg" class="p5" />
        </div>
        <div class="rating-meaning">
          <p> </p>
        </div>
      </div>
      <div class="remark-field">
        <textarea type="text" name="remark" id="remark" class="text-field"></textarea>
        <label for="remark" class="text-label">Anmerkung</label>
      </div>

      <div class="steps">
        <img src="../../img/arrow_back.svg" />
        <div class="dots">
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
        </div>
        <img src="../../img/arrow_next.svg" />
      </div>
      <div class="ripple" style="
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      background-color: #4285F4;
      z-index: 2;
      -webkit-transition: all 0.6s ease;
      transition: all 0.6s ease;
      "></div>

    </div>

    <footer>
      <? include "$root/includes/footer.php"; ?>
    </footer>

  </body>
</html>
