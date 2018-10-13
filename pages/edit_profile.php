<?php
if ( ! is_user_logged_in() ) {
  addNextSingleLineWithActionSnackbar('Melde dich an um diese Seite aufzurufen', 'Anmelden', 'window.location = "' . wp_login_url() . '";');
	header( 'Location: ' . get_home_url() ); // TODO: Snackbar "Melde dich an um diese Seite aufzurufen" [ANMELDEN]
}

if ( ! empty( $_POST ) ) {
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . get_current_user_id() ) ) {
		$_POST = array();
	  echo "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	  die();
	}

	$errors = array();



	echo "
    console.log('recived data');
	";

	die();
}
?>

<?php get_header(); ?>
  <div class="wrapper">

    <form id="edit_profile" action="<?php self_link(); ?>" method="post" novalidate>
		<?php wp_nonce_field( 'update-user_' . get_current_user_id() ); ?>
      <section class="general section">
        <h2 class="section__title">Allgemein</h2>
        <div class="general__profilePicture">
          <div class="general__profilePicture__current">
			  <?php echo get_avatar( get_current_user_id(), 128 ); ?>
          </div>
          <div class="general__profilePicture__change button button--flat">
            <span>Foto ändern</span>
          </div>
        </div>
        <div class="general__displayname input">
          <input type="text" name="displayname" id="displayname" placeholder="Max Mustermann" value="<?php echo wp_get_current_user()->display_name; ?>" required>
          <i class="material-icons">cancel</i>
          <label for="displayname" class="label">Angezeigter Name</label>
          <label for="displayname" class="error"></label>
        </div>
        <div class="general__email input">
          <input type="email" name="email" id="email" placeholder="max.mustermann@franz-haniel-gymnasium.eu" value="<?php echo wp_get_current_user()->user_email ?>" required>
          <i class="material-icons">cancel</i>
          <label for="email" class="label">E-Mail</label>
          <label for="email" class="error"></label>
        </div>
        <div class="general__firstname input">
          <input type="text" name="firstname" id="firstname" value="<?php echo wp_get_current_user()->first_name; ?>">
          <i class="material-icons">cancel</i>
          <label for="firstname" class="label">Vorname</label>
          <label for="firstname" class="error"></label>
        </div>
        <div class="general__lastname input">
          <input type="text" name="lastname" id="lastname" value="<?php echo wp_get_current_user()->last_name; ?>">
          <i class="material-icons">cancel</i>
          <label for="lastname" class="label">Nachname</label>
          <label for="lastname" class="error"></label>
        </div>
        <div class="general__resetPassword button button--light">
          <span>Passwort zurücksetzen</span>
        </div>
      </section>
      <section class="personal section">
        <h2 class="section__title">Persönlich</h2>
        <div class="personal__website input">
          <input type="text" name="website" id="website" value="<?php echo wp_get_current_user()->user_url; ?>">
          <i class="material-icons">cancel</i>
          <label for="website" class="label">Website</label>
          <label for="website" class="error"></label>
        </div>
        <div class="personal__biography input input--textarea">
          <textarea name="biograpgy" id="biograpgy" cols="30" rows="10"><?php echo wp_get_current_user()->description; ?></textarea>
          <label for="biograpgy" class="label">Steckbrief</label>
          <label for="biograpgy" class="error"></label>
        </div>
      </section>
      <section class="socialMedia section">
        <h2 class="section__title">Social Media</h2>
        <div class="socialMedia__facebook input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/facebook.svg' ?>"></i>
          <input type="text" name="facebook" id="facebook" value="<?php echo get_facebook_url(get_current_user_id()); ?>">
          <i class="material-icons">cancel</i>
          <label for="facebook" class="label">Facebook</label>
          <label for="facebook" class="error"></label>
        </div>
        <div class="socialMedia__twitter input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/twitter.svg' ?>"></i>
          <input type="text" name="twitter" id="twitter" value="<?php echo get_twitter_url(get_current_user_id()); ?>">
          <i class="material-icons">cancel</i>
          <label for="twitter" class="label">Twitter</label>
          <label for="twitter" class="error"></label>
        </div>
        <div class="socialMedia__instagram input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/instagram.svg' ?>"></i>
          <input type="text" name="instagram" id="instagram" value="<?php echo get_instagram_url(get_current_user_id()); ?>">
          <i class="material-icons">cancel</i>
          <label for="instagram" class="label">Instagram</label>
          <label for="instagram" class="error"></label>
        </div>
        <div class="socialMedia__snapchat input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/snapchat.svg' ?>"></i>
          <input type="text" name="snapchat" id="snapchat" value="<?php echo get_snapchat_url(get_current_user_id()); ?>">
          <i class="material-icons">cancel</i>
          <label for="snapchat" class="label">Snapchat</label>
          <label for="snapchat" class="error"></label>
        </div>
      </section>
      <p class="info">* Pflichtfeld</p>
      <div class="button submit">
        <span>Änderungen speichern</span>
        <div class="material-loader">
          <svg class="material-loader__circular" viewBox="25 25 50 50">
            <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle>
          </svg>
        </div>
      </div>
    </form>

  </div>

<?php get_footer(); ?>