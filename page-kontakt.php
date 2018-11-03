<?php

if ( ! empty( $_POST ) ) {

	$srcipt = '';

	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'contact' ) ) {
		$script = "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	} else {
		$errors = array();

		$name    = strip_tags( trim( $_POST["full_name"] ) );
		$email   = strip_tags( trim( $_POST["email"] ) );
		$subject = strip_tags( trim( $_POST["subject"] ) );
		$msg     = strip_tags( trim( $_POST["message"] ) );

		if ( ! isset( $name ) || strlen( $name ) == 0 ) {
			$errors['full_name'] = "Dies ist ein Pflichtfeld";
		} else if ( ! preg_match( '/^[A-Za-zÄÖÜäöü\-éèáà ]+$/', $name ) || substr_count( $name, ' ' ) < 1 ) {
			$errors['full_name'] = "Ungültiger Vor- und Nachname";
		}

		if ( ! isset( $email ) || strlen( $email ) == 0 ) {
			$errors['email'] = "Dies ist ein Pflichtfeld";
		} else if ( strlen( $email ) > 100 ) {
			$errors["email"] = "Maximal 100 Zeichen eingeben";
		} else if ( ! is_email( $email ) ) {
			$errors["email"] = "Ungültige E-Mail";
		}

		if ( ! isset( $subject ) || strlen( $subject ) == 0 ) {
			$errors['subject'] = "Dies ist ein Pflichtfeld";
		} else if ( strlen( $msg ) < 6 ) {
			$errors['subject'] = "Mindestens 6 Zeichen eingeben";
		}

		if ( ! isset( $msg ) || strlen( $msg ) == 0 ) {
			$errors['message'] = "Dies ist ein Pflichtfeld";
		} else if ( strlen( $msg ) < 30 ) {
			$errors['message'] = "Mindestens 30 Zeichen eingeben";
		}

		if ( count( $errors ) === 0 ) {
			if ( ! wp_mail( ADMIN_EMAIL_ADDRESS, "[Kontaktformular] {$subject}",
				"<b><a href='" . get_author_posts_url( get_current_user_id() ) . "'>{$name}</a> hat folgende Kontaktanfrage übermittelt:</b><br><br>
                  Name: {$name}<br>
                  E-Mail: {$email}<br>
                  Betreff: {$subject}<br><br>
                  Nachricht: <br>" . nl2br($msg), array( 'Content-Type: text/html; charset=UTF-8' ) ) ) {
				$script = "showSingleLineSnackBar('Fehler aufgetreten. Versuch es später erneut');";
			} else {
				$_POST = array();
				wp_redirect( add_query_arg('success', '', $_SERVER['REQUEST_URI']) );
			}
		}

	}

}

get_header();
if ( ! empty ( $script ) ) {
	echo "<script>" . $script . "</script>";
} ?>
	<div class="wrapper">

		<div class="main">

			<?php if ( have_posts() ) : while ( have_posts() ):
				the_post(); ?>

				<div <?php post_class( 'page' ); ?>>
					<div class="page__content">
						<div class="description">
							<p>
								<?php if ( empty( get_the_content() ) ): ?>
									Du kannst uns mit diesem Kontaktformular schnell und einfach erreichen.
								<?php else:
									echo strip_tags( get_the_content(), '<a><span><br>' );
								endif; ?>
							</p>
						</div>
						<form method="POST">
							<?php if ( isset( $_REQUEST['success'] ) ): ?>
								<div class="success">
									<img src="<?php echo get_theme_file_uri( '/img/undraw/mail.svg' ); ?>"
									     alt="Nachricht gesendet">
									<h3>Deine Nachricht wurde an uns übermittelt</h3>
									<p>Wir haben deine Nachricht erhalten und werden dir in den nächsten Tagen per E-Mail antworten.
										Behalte also dein E-Mail-Postfach im Auge.</p>
								</div>
							<?php else: ?>
								<?php wp_nonce_field( 'contact' ); ?>
								<div class="full_name input <?php echo( ! empty( $errors['full_name'] ) ? "isInvalid" : "" ); ?>">
									<input type="text" name="full_name" id="full_name" placeholder="Maximilian Mustermann"
									       value="<?php echo( isset( $_POST['full_name'] ) ? $_POST['full_name'] : ( ( is_user_logged_in() && ! ( empty( wp_get_current_user()->first_name ) && empty( wp_get_current_user()->last_name ) ) ) ? wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name : "" ) ); ?>"
									       required>
									<i class="material-icons">cancel</i>
									<label for="full_name" class="label">Vor- & Nachname</label>
									<label for="full_name"
									       class="error"><?php echo( ! empty( $errors['full_name'] ) ? $errors['full_name'] : "" ); ?></label>
								</div>
								<div class="email input <?php echo( ! empty( $errors['email'] ) ? "isInvalid" : "" ); ?>">
									<input type="email" name="email" id="email" placeholder="max.mustermann@franz-haniel-gymnasium.eu"
									       value="<?php echo( isset( $_POST['email'] ) ? $_POST['email'] : ( is_user_logged_in() ? wp_get_current_user()->user_email : "" ) ); ?>"
									       required>
									<i class="material-icons">cancel</i>
									<label for="email" class="label">E-Mail</label>
									<label for="email"
									       class="error"><?php echo( ! empty( $errors['email'] ) ? $errors['email'] : "" ); ?></label>
								</div>
								<div class="subject input <?php echo( ! empty( $errors['subject'] ) ? "isInvalid" : "" ); ?>">
									<input type="text" name="subject" id="subject"
									       value="<?php echo( isset( $_POST['subject'] ) ? $_POST['subject'] : "" ); ?>" required>
									<i class="material-icons">cancel</i>
									<label for="subject" class="label">Betreff</label>
									<label for="subject"
									       class="error"><?php echo( ! empty( $errors['subject'] ) ? $errors['subject'] : "" ); ?></label>
								</div>
								<div
									class="message input input--textarea <?php echo( ! empty( $errors['message'] ) ? "isInvalid" : "" ); ?>">
                      <textarea name="message" id="message"
                                required><?php echo( isset( $_POST['message'] ) ? $_POST['message'] : "" ); ?></textarea>
									<i class="material-icons">cancel</i>
									<label for="message" class="label">Nachricht</label>
									<label for="message"
									       class="error"><?php echo( ! empty( $errors['message'] ) ? $errors['message'] : "" ); ?></label>
								</div>
								<input type="submit" class="submit" value="Senden">
							<?php endif; ?>
						</form>
					</div>
				</div>

			<?php endwhile; endif; ?>

		</div>
		<?php get_sidebar(); ?>
	</div>

<?php get_footer(); ?>