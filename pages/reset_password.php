<?php

if ( ! empty ( $_GET ) && isset( $_GET["change"] ) ) {
	list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$rp_cookie = 'wp-resetpass-' . COOKIEHASH;
	if ( isset( $_GET['key'] ) ) {
		$value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );
		setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
		exit;
	}

	if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
		list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
		$user = check_password_reset_key( $rp_key, $rp_login );
		if ( isset( $_POST['pass1'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
			$user = false;
		}
	} else {
		$user = false;
	}

	if ( ! $user || is_wp_error( $user ) ) {
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		if ( $user && $user->get_error_code() === 'expired_key' ) {
			addNextSingleLineSnackbar( "Schüssel zum Zurücksetzen des Passworts abgelaufen" );
			wp_redirect( wp_lostpassword_url() );
		} else {
			addNextSingleLineSnackbar( "Schüssel zum Zurücksetzen des Passworts ungültig" );
			wp_redirect( wp_lostpassword_url() );
		}
		exit;
	}

	$errors = array();

	if ( ( empty ( $_POST["pass1"] ) && ! empty ( $_POST["pass2"] ) ) || ( ! empty ( $_POST["pass1"] ) && empty ( $_POST["pass2"] ) ) ) {
		if ( empty( $_POST["pass1"] ) ) {
			$errors["pass1"] = "Dies ist ein Pflichtfeld";
		}

		if ( empty( $_POST["pass2"] ) ) {
			$errors["pass2"] = "Dies ist ein Pflichtfeld";
		}
	}

	if ( isset( $_POST['pass1'] ) && $_POST['pass1'] != $_POST['pass2'] ) {
		$errors["pass2"] = "Passwörter stimmen nicht überein";
	}

	do_action( 'validate_password_reset', $errors, $user );

	if ( empty( $errors ) && isset( $_POST['pass1'] ) && ! empty( $_POST['pass1'] ) ) {
		reset_password( $user, $_POST['pass1'] );
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		addNextSingleLineSnackbar( 'Dein Passwort wurde zurückgesetzt' );
		wp_redirect( wp_login_url() );
		exit;
	}

} else if ( ! empty( $_POST ) ) {
	$script = '';
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'reset_password' ) ) {
		$_POST  = array();
		$script = "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	} else {

		$user_login = trim( $_POST['user_login'] );

		$retrieve_password = fhgnewsonline_retrieve_password( $user_login );
		if ( is_wp_error( $retrieve_password ) ) {
			$errors = array();
			foreach ( $retrieve_password->errors as $error => $msg ) {
				switch ( $error ) {
					case "empty_username":
						$errors["user_login"] = "Dies ist ein Pflichtfeld";
						break;
					case "invalid_email":
						$errors["user_login"] = "E-Mail existiert nicht";
						break;
					case "invalidcombo":
						$errors["user_login"] = "Ungültiger Benutzername oder E-Mail";
						break;
					default:
						$errors["user_login"] = ' ';
						break;
				}
			}
		} else {
			addNextSingleLineSnackbar( 'Passwort wurde zurückgesetzt. Bitte schau in dein E-Mail-Postfach.' );
			header( "Location: " . ( ! empty( $_REQUEST["redirect_to"] ) ? $_REQUEST["redirect_to"] : wp_login_url() ) );
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

	<?php if ( isset( $_GET["change"] ) ): ?>
      <form id="reset_password" action="<?php self_link(); ?>" method="post" novalidate>
		  <?php wp_nonce_field( 'reset_password' ); ?>
        <input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off"/>
        <input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>"/>
        <div
            class="pass1 input input--password input--strength <?php echo( isset( $errors["pass1"] ) ? 'isInvalid' : '' ); ?>">
          <input type="password" name="pass1" id="pass1" value="<?php echo $_POST["pass1"]; ?>" autocomplete="off"
                 required>
          <div class="strength"></div>
          <i class="material-icons">visibility</i>
          <label for="pass1" class="label">Neues Passwort</label>
          <label for="pass1" class="error"><?php echo( isset( $errors["pass1"] ) ? $errors["pass1"] : '' ); ?></label>
        </div>
        <div class="pass2 input input--password <?php echo( isset( $errors["pass2"] ) ? 'isInvalid' : '' ); ?>">
          <input type="password" name="pass2" id="pass2" value="<?php echo $_POST["pass2"]; ?>" autocomplete="off"
                 required>
          <i class="material-icons">visibility</i>
          <label for="pass2" class="label">Passwort wiederholen</label>
          <label for="pass2" class="error"><?php echo( isset( $errors["pass2"] ) ? $errors["pass2"] : '' ); ?></label>
        </div>
        <div class="submit button">
          <span>Passwort ändern</span>
        </div>
      </form>
	<?php else: ?>
      <form id="retrieve_password" action="<?php self_link(); ?>" method="post" novalidate>
		  <?php wp_nonce_field( 'reset_password' ); ?>
        <div class="user_login input <?php echo( isset( $errors["user_login"] ) ? 'isInvalid' : '' ); ?>">
          <input type="text" name="user_login" id="user_login"
                 value="<?php echo( isset( $_POST["user_login"] ) && is_user_logged_in() ? $_POST["user_login"] : wp_get_current_user()->user_login ); ?>"
                 required>
          <i class="material-icons">cancel</i>
          <label for="user_login" class="label">Benutzername oder E-Mail</label>
          <label for="user_login"
                 class="error"><?php echo( isset( $errors["user_login"] ) ? $errors["user_login"] : '' ); ?></label>
        </div>
        <p class="info">Du bekommst eine E-Mail, mit deren Hilfe du ein neues Passwort erstellen kannst.</p>
        <div class="submit button">
          <span>Passwort zurücksetzen</span>
        </div>
      </form>
	<?php endif; ?>
</div>