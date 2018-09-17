<nav>
  <ul>
    <a href="/index.php"><li class="Startseite<? echo (($GLOBALS['this_page'] == "Startseite") ? " active" : "") ?>">Startseite</li></a>
    <li id="nav_FHG-News">FHG-News<p id="dropdown-icon">▼</p></li>
      <div id="nav_FHG-News_ul">
        <ul>
          <a href="/FHG-News/additional-content"><li class="Zusatzinhalte<? echo (($GLOBALS['this_page'] == "Zusatzinhalte") ? " active" : "") ?>">Zusatzinhalte</li></a>
          <!--<a href="/FHG-News/surveys"><li class="Umfragen<? echo (($GLOBALS['this_page'] == "Umfragen") ? " active" : "") ?>">Umfragen</li></a>
          <a href="/FHG-News/feedback"><li class="Feedback<? echo (($GLOBALS['this_page'] == "Feedback") ? " active" : "") ?>">Feedback</li></a> -->
        </ul>
      </div>
    <a href="/about"><li id="nav_under_FHG-News" class="Ueber-uns<? echo (($this_page == "Ueber-uns") ? " active" : "") ?>">Über uns</li></a>
    <a href="/contact"><li class="Kontekt<? echo (($GLOBALS['this_page'] == "Kontakt") ? " active" : "") ?>">Kontakt</li></a>
  </ul>
</nav>
