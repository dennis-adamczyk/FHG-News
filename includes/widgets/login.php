<div id="login" title="Login">
  <img src="/img/user.svg" alt="Login" />
</div>
<div id="login-form" class="user_dropdown">
  <div id="overlay"></div>
  <div id="triangle"></div>
  <div id="field">
    <form action="javascript:void(0);" autocomplete="off" novalidate="true" id="form-login">
      <div class="input-group">
        <input type="email" id="login-form-email" class="form-control" name="email" tabindex="1" required />
        <label class="form-text-label">E-Mail</label>
        <label class="error"></label>
        <span class="forgot-password" tabindex="5"><a href="/login/recover.php?mode=email">E-Mail vergessen</a></span>
      </div>
      <div class="input-group">
        <input type="password" id="login-form-password" class="form-control" name="password" tabindex="2" required />
        <label class="form-text-label">Passwort</label>
        <label class="error"></label>
        <span class="forgot-password" tabindex="6"><a href="/login/recover.php?mode=password">Passwort vergessen</a></span>
      </div>
      <div class="input-group">
        <label class="remember-me">
          <input type="checkbox"/>
          <span class="label-text">Angemeldet bleiben</span>
        </label>
      </div>
      <div class="input-group submit-input">
        <input type="submit" class="submit" value="ANMELDEN" tabindex="3" />
      </div>
    </form>
      <span class="or">oder</span>
      <div class="input-group register-input">
        <button class="register" onclick="window.location.replace('/login/register.php')" tabindex="4">REGISTRIEREN</button>
      </div>
  </div>
</div>
