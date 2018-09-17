<footer>
  <div class="footer-content">
    <ul>
      <li>
        <a href="/">DuisPaper</a>
      </li>
      <li title="Letzte Aktualisierung">
        <i class="material-icons">refresh</i> <? echo(date("d.m.Y, H:i",filemtime(realpath($_SERVER["DOCUMENT_ROOT"]) . '/index.php')) . ' Uhr'); ?>
      </li>
      <li>
        <a href="/privacy/">Datenschutz</a>
      </li>
      <li>
        <a href="/imprint/">Impressum</a>
      </li>
      <li>
        <a href="/contact/">Kontakt</a>
      </li>
    </ul>
  </div>
</footer>
