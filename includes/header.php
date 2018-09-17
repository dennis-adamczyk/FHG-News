<header>
  <div class="header-menu" title="Menü"><i class="material-icons">menu</i></div>
  <p class="header-title" onselectstart="return false"></p>
  <div class="header-notifications" title="Benachrichtigungen" onclick="window.location = '/newsletter/'; "><i class="material-icons">notifications_none</i><i class="material-icons" style="display: none;">notifications</i></div>
  <? if(is_logged_in()) { ?>
    <div class="header-more" title="Optionen"><i class="material-icons">more_vert</i></div>
  <? } ?>
  <div class="progress">
    <div class="indeterminate"></div>
  </div>
</header>
<? if(is_logged_in()) { ?>
<div class="header-more-menu-overlay"></div>
<div class="header-more-menu">
  <ul>
    <li data-link="https://duispaper.de/editorial/change_password/">
      <p>Passwort ändern</p>
    </li>
    <li data-link="https://duispaper.de/editorial/system/logout.php">
      <p>Abmelden</p>
    </li>
  </ul>
</div>
<? } ?>
<div class="header-notifications-menu-overlay"></div>
<div class="header-notifications-menu">
  <div class="top">
    <p>Benachrichtigungen</p>
    <div class="settings"><i class="material-icons">settings</i></div>
  </div>
  <div class="contents">
    <div class="empty">
      <div class="icon"><i class="material-icons">notifications</i></div>
      <h4>Hier findest du deine<br />Benachrichtigungen.</h4>
      <p>Wenn es Neuigkeiten zur Schülerzeitung gibt oder du Redakteur bist, bekommst du hier Benachrichtigungen darüber.</p>
    </div>
  </div>
</div>

<? if(is_logged_in()) { ?>
<script src="/editorial/js/logged_in.js"></script>
<? } ?>
