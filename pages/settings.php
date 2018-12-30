<?php
$script = "";
if ( ! is_user_logged_in() ) {
	addNextSingleLineSnackbar( 'Melde dich an um diese Seite aufzurufen' );
	wp_redirect( wp_login_url( $_SERVER['REQUEST_URI'] ) );
}

if ( isset( $_REQUEST['newsletter_email_sent'] ) ) {
	$script .= "showSingleLineSnackBar('Wir haben dir eine Bestätigungsmail an deine E-Mail-Adresse gesendet.');";
	$script .= "window.history.replaceState({}, null, '.');";
}
if ( isset( $_REQUEST['newsletter_logged_in'] ) ) {
	$script .= "showSingleLineSnackBar('Deine E-Mail-Adresse wurde bestätigt.');";
	$script .= "window.history.replaceState({}, null, '.');";
}
if ( isset( $_REQUEST['newsletter_logout_email_sent'] ) ) {
	$script .= "showSingleLineSnackBar('Wir haben dir eine Abmeldungsmail an deine E-Mail-Adresse gesendet.');";
	$script .= "window.history.replaceState({}, null, '.');";
}
if ( isset( $_REQUEST['newsletter_logged_out'] ) ) {
	$script .= "showSingleLineSnackBar('Deine E-Mail-Adresse wurde aus dem Newsletter entfernt.');";
	$script .= "window.history.replaceState({}, null, '.');";
}

get_header(); ?>
  <script><?php echo $script; ?></script>
  <div class="emailNewsletterLogout">
    <form id="cr_logout" class="layout_form cr_form cr_font" action="https://eu2.cleverreach.com/f/205597-203680/wcu/"
          method="post">
      <input id="text4347481" name="email" value="" type="hidden"/>
    </form>
  </div>
  <div class="emailNewsletterAlert">
    <div class="htmlContent">
      <p>Bestätige, dass du kein Roboter bist</p>
      <form id="cr_login" class="layout_form cr_form cr_font" action="https://eu2.cleverreach.com/f/205597-203680/wcs/"
            method="post">

        <div class="editable_content">
          <input id="text4347480" name="email" value="" type="hidden"/>
          <input id="text4347524" name="1031379" type="hidden" value=""/>
        </div>

        <div id="4347484" rel="recaptcha" class="cr_ipe_item ui-sortable musthave">
          <script src="https://www.google.com/recaptcha/api.js" async defer></script>
          <div id="recaptcha_v2_widget" class="g-recaptcha" data-callback="callitback" data-theme="light"
               data-size="normal" data-sitekey="6Lfhcd0SAAAAAOBEHmAVEHJeRnrH8T7wPvvNzEPD"
               data-callback="imNotARobot"></div>
        </div>
      </form>
    </div>
    <div class="buttons">
      <div class="abort button button--flat">
        <span>Abbrechen</span>
      </div>
      <div class="done button button--flat">
        <span>Fertig</span>
      </div>
    </div>
  </div>
  <div class="wrapper">

    <form id="settings" action="<?php self_link(); ?>" method="post" novalidate>
		<?php wp_nonce_field( 'settings_' . get_current_user_id() ); ?>
      <section class="general section">
        <h2 class="section__title">Allgemein</h2>
        <ul class="section__list">
          <li class="changePassword section__list__item item--link"
              data-link="<?php echo get_reset_password_url(); ?>">
            <span>Passwort ändern</span>
          </li>
          <li class="rememberMe section__list__item item--toggle"
              data-settingsname="<?php echo REMEMBER_ME_SETTINGS_KEY; ?>">
            <span>Angemeldet bleiben</span>
            <input type="checkbox" class="toggle" name="rememberMe"
                   id="rememberMe" <?php echo( get_setting( REMEMBER_ME_SETTINGS_KEY, 'bool' ) ? "checked" : "" ); ?>>
          </li>
        </ul>
      </section>
      <section class="notifications section">
        <h2 class="section__title">Benachrichtigungen</h2>
        <ul class="section__list">
          <li class="pushNotifications section__list__item item--toggle"
              data-settingsname="<?php echo PUSH_NOTIFICATIONS_SETTINGS_KEY; ?>">
            <span>Push Benachrichtigungen</span>
            <input type="checkbox" class="toggle" name="pushNotifications"
                   id="pushNotifications" <?php echo( get_setting( PUSH_NOTIFICATIONS_SETTINGS_KEY, 'bool' ) ? "checked" : "" ); ?>>
          </li>
          <li class="emailNewsletter section__list__item item--toggle"
              data-settingsname="<?php echo EMAIL_NEWSLETTER_SETTINGS_KEY; ?>">
            <span>E-Mail-Newsletter</span>
            <input type="checkbox" class="toggle" name="emailNewsletter"
                   id="emailNewsletter" <?php echo( get_setting( EMAIL_NEWSLETTER_SETTINGS_KEY, 'bool' ) ? "checked" : "" ); ?>>
          </li>
        </ul>
      </section>
    </form>

  </div>

<?php get_footer(); ?>