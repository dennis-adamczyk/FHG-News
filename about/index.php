<? $root = realpath($_SERVER["DOCUMENT_ROOT"]); include "$root/system/init.php"; ?>
<script>
  var short_title = 'Über uns';
  var long_title = 'DuisPaper <i class="material-icons">keyboard_arrow_right</i> Über uns';
  var page_title = 'DuisPaper - Über uns';
</script>
<!DOCTYPE html>
<html lang="de">
  <head>
    <? include "$root/includes/head.php"; ?>
    <script>document.write('<title>' + page_title + '</title>');</script>
    <link rel="stylesheet" href="css/page.css" />
  </head>
  <body>

    <? include "$root/includes/header.php"; ?>
    <? include "$root/includes/nav.php"; ?>

    <div class="content">

      <div class="about">
        <h1>Über Uns</h1>

        <h3>Unsere Geschichte</h3>
        <p>
          Schon vor einem Jahr haben die heutigen Zeitungsgründer Melanie (hat die Redaktion verlassen), Paul, Vanessa und Dennis in ihrem Wirtschaftskurs eine Aufgabe bekommen, die letztendlich die Idee zur Zeitung hervorbrachte. Herr Junkers, der damalige Kurs-Lehrer, gab den Schülern nämlich die Aufgabe über ein Firmenkonzept nachzudenken, welches man auch wirklich realisieren könnte und das wollte er auch mit einer Idee machen, hat er den Schülern versprochen. Die Schüler*innen haben viele Ideen gesammelt und als Ergebnis kamen selbstgestaltbare Sportbeutel, selbstgemachte Schlüsselhakenleisten und unter anderem auch eine Schülerzeitungsfirma namens DuisPaper heraus. Einige Ideen waren wegen des enormen Aufwandes, wie z.B. bei den Schlüsselhackenleisten, nicht realisierbar, aber unsere Schülerzeitungsidee hat Herrn Junkers überzeugt.<br />
          Noch im Sommer letzten Jahres hat die Produktion der ersten Ausgabe stattgefunden und wurde dann am 19. Juni 2017 veröffentlicht. Mittlerweile hat die Redaktion ein neunköpfiges Team und wir suchen natürlich stetig weitere Redakteure, Autoren und motivierte Leute, die anpacken. Bei Interesse würden wir uns freuen, wenn du uns entweder mithilfe des <a href="/contact/">Kontaktformulars</a> oder persönlich (jeden Donnerstag in der Mittagspause im Raum 011) kontaktierst.
        </p>

        <h3>Unser Team</h3>
        <div class="team">
          <img src="img/Redaktionsfoto.png" />
          <p>erste Reihe (v.l.n.r): Ebrar Özdemir (Redakteurin), Niko Vossmeyer (Redakteur), Irem Karatas (Redakteurin)
            <br>zweite Reihe (v.l.n.r.): Paul Paschmann (Mitgründer), Dennis Adamczyk (Chefredakteur), Vanessa Adamczyk (Mitgründerin)
            <br>dritte Reihe (v.l.n.r.): Jan Detka (Redakteur), Malina Straßburger (Redakteurin), Josef Ali (Senior-Redakteur)
          </p>
        </div>

      </div>

      <? include "$root/includes/footer.php"; ?>
    </div>

  </body>
</html>
