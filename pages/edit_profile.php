<?php
if ( ! is_user_logged_in() ) {
  addNextSingleLineSnackbar('Melde dich an um diese Seite aufzurufen');
	wp_redirect( wp_login_url( $_SERVER['REQUEST_URI'] ) );
}

if ( ! empty( $_POST ) ) {

	header( 'content-type: text/html; charset=utf-8' );
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . get_current_user_id() ) ) {
		$_POST = array();
		echo "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
		die();
	}

	if ( isset( $_POST["profilePic"] ) ) {
		if ( $_POST["profilePic"] === "delete" ) {
			if ( delete_profile_picture( null ) ) {
				echo "S" . get_avatar_url( get_current_user_id(), array( "size" => 128 ) );
			} else {
				echo "F";
			}
		} else {
			try {
				if ( set_profile_picture( null, $_POST["profilePic"] ) !== false ) {
					echo "S" . get_profile_picture_url( null );
				} else {
					echo "F";
				}
			} catch ( Exception $e ) {
				echo "F";
			}
		}
		die();
	}

	$errors = array();

	$displayname = strip_tags( trim( $_POST["displayname"] ) );
	$email       = strip_tags( trim( $_POST["email"] ) );
	$firstname   = strip_tags( trim( $_POST["firstname"] ) );
	$lastname    = strip_tags( trim( $_POST["lastname"] ) );
	$website     = strip_tags( trim( $_POST["website"] ) );
	$biography   = strip_tags( trim( $_POST["biography"] ) );
	$facebook    = strip_tags( trim( $_POST["facebook"] ) );
	$twitter     = strip_tags( trim( $_POST["twitter"] ) );
	$instagram   = strip_tags( trim( $_POST["instagram"] ) );
	$snapchat    = strip_tags( trim( $_POST["snapchat"] ) );
	$enter       = boolval( $_POST["enter"] );

	if ( ! isset( $displayname ) || empty( $displayname ) || strlen( $displayname ) === 0 ) {
		$errors["displayname"] = "Dies ist ein Pflichtfeld";
	} else if ( strlen( $displayname ) > 250 ) {
		$errors["displayname"] = "Maximal 250 Zeichen eingeben";
	}

	if ( ! isset( $email ) || empty( $email ) || strlen( $email ) === 0 ) {
		$errors["email"] = "Dies ist ein Pflichtfeld";
	} else if ( strlen( $email ) > 100 ) {
		$errors["email"] = "Maximal 100 Zeichen eingeben";
	} else if ( ! is_email( $email ) ) {
		$errors["email"] = "Ungültige E-Mail";
	}

	if ( strlen( $firstname ) !== 0 && ! preg_match( "/^([a-zA-ZäöüÄÖÜß'\- ]+)$/", $firstname ) ) {
		$errors["firstname"] = "Ungültiger Vorname";
	}

	if ( strlen( $lastname ) !== 0 && ! preg_match( "/^([a-zA-ZäöüÄÖÜß'\- ]+)$/", $lastname ) ) {
		$errors["lastname"] = "Ungültiger Nachname";
	}

	if ( strlen( $website ) !== 0 ) {
		if ( ! filter_var( $website, FILTER_VALIDATE_URL ) ) {
			$errors["website"] = "Ungültige Internetadresse";
		} else if ( esc_url( $website, array( 'http', 'https', 'mailto', 'tel', 'fax' ) ) === '' ) {
			$errors["website"] = "Ungültige Internetadresse";
		}
	}

	if ( strlen( $facebook ) !== 0 ) {
		if ( strpos( $facebook, '@' ) === 0 ) {
			$facebook = substr( $facebook, 1 );
		}
		if ( strlen( $facebook ) < 5 ) {
			$errors["facebook"] = "Mindestens 5 Zeichen";
		} else if ( ! preg_match( "/^([a-zA-Z0-9.]+)$/", $facebook ) ) {
			$errors["facebook"] = "Enthält ungültige Zeichen";
		}
	}

	if ( strlen( $twitter ) !== 0 ) {
		if ( strpos( $twitter, '@' ) === 0 ) {
			$twitter = substr( $twitter, 1 );
		}
		if ( strlen( $twitter ) < 1 ) {
			$errors["twitter"] = "Mindestens 1 Zeichen";
		} else if ( strlen( $twitter ) > 15 ) {
			$errors["twitter"] = "Maximal 15 zeichen";
		} else if ( ! preg_match( "/^([a-zA-Z0-9_]+)$/", $twitter ) ) {
			$errors["twitter"] = "Enthält ungültige Zeichen";
		}
	}

	if ( strlen( $instagram ) !== 0 ) {
		if ( strpos( $instagram, '@' ) === 0 ) {
			$instagram = substr( $instagram, 1 );
		}
		if ( strlen( $instagram ) < 1 ) {
			$errors["instagram"] = "Mindestens 1 Zeichen";
		} else if ( strlen( $instagram ) > 30 ) {
			$errors["instagram"] = "Maximal 30 Zeichen";
		} else if ( ! preg_match( "/^([a-zA-Z_])$/", substr( $instagram, 0, 1 ) ) ) {
			$errors["instagram"] = "Darf nicht mit Zahl oder Sonderzeichen beginnen";
		} else if ( ! preg_match( "/^([a-zA-Z0-9._]+)$/", $instagram ) ) {
			$errors["instagram"] = "Enthält ungültige Zeichen";
		}
	}

	if ( strlen( $snapchat ) !== 0 ) {
		if ( strpos( $snapchat, '@' ) === 0 ) {
			$snapchat = substr( $snapchat, 1 );
		}
		if ( strlen( $snapchat ) < 3 ) {
			$errors["snapchat"] = "Mindestens 3 Zeichen";
		} else if ( ! preg_match( "/^([a-zA-Z0-9._-]+)$/", $snapchat ) ) {
			$errors["snapchat"] = "Enthält ungültige Zeichen";
		}
	}

	if ( ! empty( $errors ) ) {
		echo "E" . json_encode( $errors );
		die();
	} else if ( $enter ) {
		$status[] = wp_update_user( (object) array(
			'ID'           => get_current_user_id(),
			'display_name' => $displayname,
			'user_email'   => $email,
			'first_name'   => $firstname,
			'last_name'    => $lastname,
			'user_url'     => $website,
			'description'  => $biography,
		) );
		$status[] = set_facebook_name( get_current_user_id(), $facebook );
		$status[] = set_twitter_name( get_current_user_id(), $twitter );
		$status[] = set_instagram_name( get_current_user_id(), $instagram );
		$status[] = set_snapchat_name( get_current_user_id(), $snapchat );
		foreach ( $status as $val ) {
			if ( is_wp_error( $val ) ) {
				echo "F" . $val->get_error_message();
				die();
			}
		}
		echo "S";
		die();
	} else {
		echo "E{}";
	}


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
          <input type="file" accept="image/*" name="avatar" id="avatar">
        </div>
        <div class="general__displayname input">
          <input type="text" name="displayname" id="displayname" placeholder="Max Mustermann"
                 value="<?php echo wp_get_current_user()->display_name; ?>" required>
          <i class="material-icons">cancel</i>
          <label for="displayname" class="label">Angezeigter Name</label>
          <label for="displayname" class="error"></label>
        </div>
        <div class="general__email input">
          <input type="email" name="email" id="email" placeholder="max.mustermann@franz-haniel-gymnasium.eu"
                 value="<?php echo wp_get_current_user()->user_email ?>" required>
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
        <div class="general__resetPassword button button--light"
             onclick="window.location = '<?php echo get_reset_password_url(); ?>'">
          <span>Passwort ändern</span>
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
          <textarea name="biography" id="biograpgy" cols="30"
                    rows="10"><?php echo wp_get_current_user()->description; ?></textarea>
          <label for="biograpgy" class="label">Steckbrief</label>
          <label for="biograpgy" class="error"></label>
        </div>
      </section>
      <section class="socialMedia section">
        <h2 class="section__title">Social Media</h2>
        <div class="socialMedia__facebook input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/facebook.svg' ?>"></i>
          <input type="text" name="facebook" id="facebook" placeholder="Benutzername"
                 value="<?php echo get_facebook_name( get_current_user_id() ); ?>">
          <i class="material-icons">cancel</i>
          <label for="facebook" class="label">Facebook</label>
          <label for="facebook" class="error"></label>
        </div>
        <div class="socialMedia__twitter input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/twitter.svg' ?>"></i>
          <input type="text" name="twitter" id="twitter" placeholder="Benutzername"
                 value="<?php echo get_twitter_name( get_current_user_id() ); ?>">
          <i class="material-icons">cancel</i>
          <label for="twitter" class="label">Twitter</label>
          <label for="twitter" class="error"></label>
        </div>
        <div class="socialMedia__instagram input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/instagram.svg' ?>"></i>
          <input type="text" name="instagram" id="instagram" placeholder="Benutzername"
                 value="<?php echo get_instagram_name( get_current_user_id() ); ?>">
          <i class="material-icons">cancel</i>
          <label for="instagram" class="label">Instagram</label>
          <label for="instagram" class="error"></label>
        </div>
        <div class="socialMedia__snapchat input input--leadingIcon">
          <i class="material-icons leadingIcon"><img
                src="<?php echo get_template_directory_uri() . '/img/icons/snapchat.svg' ?>"></i>
          <input type="text" name="snapchat" id="snapchat" placeholder="Benutzername"
                 value="<?php echo get_snapchat_name( get_current_user_id() ); ?>">
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
            <circle class="material-loader__circular__path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                    stroke-miterlimit="10"></circle>
          </svg>
        </div>
      </div>
    </form>

  </div>

<?php get_footer(); ?>