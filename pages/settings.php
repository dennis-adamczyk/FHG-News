<?php
if ( ! is_user_logged_in() ) {
	addNextSingleLineWithActionSnackbar( 'Melde dich an um diese Seite aufzurufen', 'Anmelden', 'window.location = "' . wp_login_url() . '";' );
	wp_redirect( get_home_url() );
}

get_header(); ?>
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
			<?php
			$email_newsletter_translate = array(
				'weekly'  => 'Wöchentlich',
				'monthly' => 'Monatlich',
				'none'    => 'Deaktiviert'
			);
			?>
          <li class="emailNewsletter section__list__item item--select"
              data-settingsname="<?php echo EMAIL_NEWSLETTER_SETTINGS_KEY; ?>">
            <span>E-Mail-Newsletter</span>
            <span class="selected">
                <?php echo $email_newsletter_translate[ get_setting( EMAIL_NEWSLETTER_SETTINGS_KEY ) ]; ?>
            </span>
            <ul class="select">
              <li data-value="weekly">Wöchentlich</li>
              <li data-value="monthly">Monatlich</li>
              <li data-value="none">Deaktiviert</li>
            </ul>
          </li>
        </ul>
      </section>
    </form>

  </div>

<?php get_footer(); ?>