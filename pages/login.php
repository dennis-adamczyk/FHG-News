<?php
if ( ! empty( $_POST ) ) {
	$script = '';
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'login' ) ) {
		$_POST  = array();
		$script = "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	} else {

		$info                  = array();
		$info['user_login']    = trim( $_POST['username'] );
		$info['user_password'] = trim( $_POST['password'] );
		$info['remember']      = true;

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error( $user_signon ) ) {
			$errors = array();
			foreach ( $user_signon->errors as $error => $msg ) {
				switch ( $error ) {
					case "empty_username":
						$errors["username"] = "Dies ist ein Pflichtfeld";
						break;
					case "empty_password":
						$errors["password"] = "Dies ist ein Pflichtfeld";
						break;
					case "invalid_username":
						$errors["username"] = "Benutzer existiert nicht";
						break;
					case "incorrect_password":
						$errors["password"] = "Passwort falsch";
						break;
					default:
						$errors["username"] = ' ';
						$errors["password"] = ' ';
						break;
				}
			}
		} else {
			header( "Location: " . (! empty( $_REQUEST["redirect_to"] ) ? $_REQUEST["redirect_to"] : get_home_url()) );
			die();
		}

	}
}
?>

<?php get_header();
if ( ! empty ( $script ) ) {
	echo "<script>" . $script . "</script>";
} ?>
<div class="wrapper">
  <img class="logo" src="<?php echo get_template_directory_uri() . "/img/fhgnews.svg"; ?>" alt="FHG News">

  <form id="login" action="<?php self_link(); ?>" method="post" novalidate>
	  <?php wp_nonce_field( 'login' ); ?>
    <div class="username input <?php echo( isset( $errors["username"] ) ? 'isInvalid' : '' ); ?>">
      <input type="text" name="username" id="username" value="<?php echo $_POST["username"]; ?>" required>
      <i class="material-icons">cancel</i>
      <label for="username" class="label">Benutzername</label>
      <label for="username"
             class="error"><?php echo( isset( $errors["username"] ) ? $errors["username"] : '' ); ?></label>
    </div>
    <div class="password input input--password <?php echo( isset( $errors["password"] ) ? 'isInvalid' : '' ); ?>">
      <input type="password" name="password" id="password" value="<?php echo $_POST["password"]; ?>" required>
      <i class="material-icons">visibility</i>
      <label for="password" class="label">Passwort</label>
      <label for="password"
             class="error"><?php echo( isset( $errors["password"] ) ? $errors["password"] : '<a class="forgot" href="#">Passwort vergessen?</a>' ); ?></label>
    </div>
    <a class="forgot" href="#">Passwort vergessen?</a>
    <div class="submit button">
      <span>Login</span>
      <div class="material-loader">
        <svg class="material-loader__circular" viewBox="25 25 50 50">
          <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                  stroke-miterlimit="10"></circle>
        </svg>
      </div>
    </div>
    <div class="register button button--light" onclick="window.location = '<?php echo wp_registration_url(); ?>'">
      <span>Kein Account? Jetzt registrieren</span>
    </div>
  </form>
</div>