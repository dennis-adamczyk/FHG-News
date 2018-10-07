<?php
if ( ! is_user_logged_in() ) {
	header( 'Location: ' . get_home_url() ); // TODO: Snackbar "Melde dich an um diese Seite aufzurufen" [ANMELDEN]
}

if ( ! empty( $_POST ) ) {
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . get_current_user_id() ) ) {
		$_POST = array();
	  echo "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	  exit;
	}

	echo "
    console.log('recived data');
	";

	exit;
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
          <input type="text" placeholder="Max Mustermann" required>
          <i class="material-icons">cancel</i>
          <label for="" class="label">Angezeigter Name</label>
          <label for="" class="error"></label>
        </div>
        <div class="general__email input">
          <input type="email" placeholder="max.mustermann@franz-haniel-gymnasium.eu" required>
          <i class="material-icons">cancel</i>
          <label for="" class="label">E-Mail</label>
          <label for="" class="error"></label>
        </div>
        <div class="general__firstname input">
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Vorname</label>
          <label for="" class="error"></label>
        </div>
        <div class="general__lastname input">
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Nachname</label>
          <label for="" class="error"></label>
        </div>
        <div class="general__resetPassword button button--light">
          <span>Passwort zurücksetzen</span>
        </div>
      </section>
      <section class="personal section">
        <h2 class="section__title">Persönlich</h2>
        <div class="personal__website input">
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Website</label>
          <label for="" class="error"></label>
        </div>
        <div class="personal__biography input input--textarea">
          <textarea name="" id="" cols="30" rows="10"></textarea>
          <label for="" class="label">Steckbrief</label>
          <label for="" class="error"></label>
        </div>
      </section>
      <section class="socialMedia section">
        <h2 class="section__title">Social Media</h2>
        <div class="socialMedia__facebook input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/facebook.svg' ?>"></i>
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Facebook</label>
          <label for="" class="error"></label>
        </div>
        <div class="socialMedia__twitter input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/twitter.svg' ?>"></i>
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Twitter</label>
          <label for="" class="error"></label>
        </div>
        <div class="socialMedia__instagram input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/instagram.svg' ?>"></i>
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Instagram</label>
          <label for="" class="error"></label>
        </div>
        <div class="socialMedia__snapchat input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/snapchat.svg' ?>"></i>
          <input type="text">
          <i class="material-icons">cancel</i>
          <label for="" class="label">Snapchat</label>
          <label for="" class="error"></label>
        </div>
      </section>
      <p class="info">* Pflichtfeld</p>
      <input type="submit" name="save_changes" value="Änderungen speichern" class="submit">
    </form>

  </div>

<?php get_footer(); ?>