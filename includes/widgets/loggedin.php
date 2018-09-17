<style>
  <? if($user_data['role'] == 2) { ?>
    header div#user-menu {
      width: 270px;
    }
  <? } ?>
</style>

<div id="profile" title="Login">
  <img src="/img/user.svg" alt="Menu" />
</div>
<div id="user-menu" class="user_dropdown">
  <div id="overlay"></div>
  <div id="triangle"></div>
  <div id="field">
    <div id="profile-preview">
      <div class="pic">
        <img src="/img/no-image.svg" alt="Profilbild" />
      </div>
      <div class="name">
        <p>
        <? echo($user_data['first_name'] . ' ' . $user_data['last_name']); ?>
        </p>
      </div>
      <div class="role" style="background-color: <? echo(get_role_color($user_data['role'])); ?>;">
        <p>
          <? echo(($user_data['gender'] == "m") ? get_role_name($user_data['role']) : get_role_name_f($user_data['role'])); ?>
        </p>
      </div>
    </div>
    <ul>
      <li>
        <a href="/login/settings.php">Einstellungen</a>
      </li>
      <li>
        <a href="/login/changepassword.php">Passwort ändern</a>
      </li>
      <li>
        <a href="/login/logout.php">Abmelden</a>
      </li>
    </ul>
  </div>
</div>
