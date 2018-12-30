<?php
if ( ! empty( $_POST ) ) {
	$script = '';
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'register' ) ) {
		$_POST  = array();
		$script = "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	} else {

		$user_login = trim( $_POST['username'] );
		$user_email = trim( $_POST['email'] );

		$user_registration = register_new_user( $user_login, $user_email );
		if ( is_wp_error( $user_registration ) ) {
			$errors = array();
			foreach ( $user_registration->errors as $error => $msg ) {
				switch ( $error ) {
					case "empty_username":
						$errors["username"] = "Dies ist ein Pflichtfeld";
						break;
					case "empty_email":
						$errors["email"] = "Dies ist ein Pflichtfeld";
						break;
					case "invalid_username":
						$errors["username"] = "Benutzer beinhaltet ungültige Zeichen";
						break;
					case "invalid_email":
						$errors["email"] = "Ungültige E-Mail-Adresse";
						break;
					case "username_exists":
						$errors["username"] = "Benutzername bereits vergeben";
						break;
					case "email_exists":
						$errors["email"] = "E-Mail wird bereits von anderem Benutzer verwendet";
						break;
					case "registerfail":
						$script = "showSingleLineWithActionSnackbar('Fehler aufgetreten', 'Erneut versuchen', function() { jQuery('form').submit(); });";
						break;
					default:
						$errors["username"] = ' ';
						$errors["email"]    = ' ';
						break;
				}
			}
		} else if ( is_numeric( $user_registration ) ) {
			wp_redirect( '?success' );
			die();
		} else {
			$script = "showSingleLineWithActionSnackbar('Fehler aufgetreten', 'Erneut versuchen', function() { jQuery('form').submit(); });";
			die();
		}

	}
}
?>

<?php get_header();
if ( ! empty ( $script ) ) {
	echo "<script>" . $script . "</script>";
} ?>
<?php if ( isset( $_REQUEST['success'] ) ): ?>
  <div class="success">
    <img src="<?php echo get_theme_file_uri( '/img/undraw/add_user.svg' ) ?>" alt="Konto registriert">
    <h3>Dein Konto wurde erstellt</h3>
    <p>Wir haben dir eine E-Mail zugeschickt. Bestätige mithilfe dieser dein Konto und entscheide dich für ein
      Passwort.</p>
    <a href="<?php echo wp_login_url(); ?>" class="button button--flat">
      <span>Jetzt anmelden</span>
    </a>
  </div>
<?php else: ?>
  <div class="wrapper">
    <img class="logo" src="<?php echo get_template_directory_uri() . "/img/fhgnews.svg"; ?>" alt="FHG News">

    <form id="register" action="<?php self_link(); ?>" method="post" novalidate>
		<?php wp_nonce_field( 'register' ); ?>
      <div class="username input <?php echo( isset( $errors["username"] ) ? 'isInvalid' : '' ); ?>">
        <input type="text" name="username" id="username" placeholder="Max Mustermann"
               value="<?php echo $_POST["username"]; ?>" required>
        <i class="material-icons">cancel</i>
        <label for="username" class="label">Benutzername</label>
        <label for="username"
               class="error"><?php echo( isset( $errors["username"] ) ? $errors["username"] : '' ); ?></label>
      </div>
      <div class="email input <?php echo( isset( $errors["email"] ) ? 'isInvalid' : '' ); ?>">
        <input type="email" name="email" id="email" placeholder="max.muster@franz-haniel-gymnasium.de"
               value="<?php echo $_POST["email"]; ?>" required>
        <i class="material-icons">cancel</i>
        <label for="email" class="label">E-Mail</label>
        <label for="email" class="error"><?php echo( isset( $errors["email"] ) ? $errors["email"] : '' ); ?></label>
      </div>
      <p class="info">Du erhältst eine Bestätigung der Registrierung per E-Mail.</p>
      <div class="submit button">
        <span>Registrieren</span>
        <div class="material-loader">
          <svg class="material-loader__circular" viewBox="25 25 50 50">
            <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                    stroke-miterlimit="10"></circle>
          </svg>
        </div>
      </div>
      <div class="login button button--light" onclick="window.location = '<?php echo wp_login_url(); ?>'">
        <span>Bereits ein Konto? Anmelden</span>
      </div>
    </form>
  </div>
<?php endif; ?>