<?php

if ( ! empty( $_POST ) ) {

	$srcipt = '';

	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'your-contribution_' . get_current_user_id() ) ) {
		$script = "showSingleLineSnackBar('Verifikation fehlgeschlagen');";
	} else {
		$errors = array();

		$type      = strip_tags( trim( $_POST["type"] ) );
		$email_msg = '';

		switch ( $type ) {
			case "student":
				$name  = strip_tags( trim( $_POST["student-name"] ) );
				$email = strip_tags( trim( $_POST["student-email"] ) );
				$class = str_replace( ' ', '', strip_tags( trim( $_POST["student-class"] ) ) );
				$age   = strip_tags( trim( $_POST["student-age"] ) );
				$msg   = strip_tags( trim( $_POST["student-message"] ) );

				if ( ! isset( $name ) || strlen( $name ) == 0 ) {
					$errors['student-name'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^[A-Za-zÄÖÜäöü\-éèáà ]+$/', $name ) || substr_count( $name, ' ' ) < 1 ) {
					$errors['student-name'] = "Ungültiger Vor- und Nachname";
				}

				if ( ! isset( $email ) || strlen( $email ) == 0 ) {
					$errors['student-email'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $email ) > 100 ) {
					$errors["student-email"] = "Maximal 100 Zeichen eingeben";
				} else if ( ! is_email( $email ) ) {
					$errors["student-email"] = "Ungültige E-Mail";
				} else if ( substr_count( strtolower( $email ), '@franz-haniel-gymnasium.eu' ) !== 1 ) {
					$errors["student-email"] = "E-Mail muss franz-haniel-gymnasium.eu als Domain haben";
				}

				if ( ! isset( $class ) || strlen( $class ) == 0 ) {
					$errors['student-class'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^([5-9][A-Ha-h]|EF|Q1|Q2)$/', $class ) ) {
					$errors['student-class'] = "Ungültige Klasse/Stufe";
				}

				if ( ! isset( $age ) || strlen( $age ) == 0 ) {
					$errors['student-age'] = "Dies ist ein Pflichtfeld";
				} else {
					$age = intval( $age );

					if ( $age < 9 ) {
						$errors['student-age'] = "Du bist zu jung";
					} else if ( $age > 22 ) {
						$errors['student-age'] = "Du bist zu alt";
					}
				}

				if ( ! isset( $msg ) || strlen( $msg ) == 0 ) {
					$errors['student-message'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $msg ) < 20 ) {
					$errors['student-message'] = "Mindestens 20 Zeichen eingeben";
				}

				$email_msg = "<b>Der Schüler {$name} hat folgende Anfrage eingereicht:</b><br><br>
                      Name: {$name}<br>
                      iServ-E-Mail: {$email}<br>
                      Klasse/Stufe: {$class}<br>
                      Alter: {$age} Jahre<br><br>
                      Nachricht:<br>" . nl2br( $msg );
				break;

			case "teacher":
				$name     = strip_tags( trim( $_POST["teacher-name"] ) );
				$email    = strip_tags( trim( $_POST["teacher-email"] ) );
				$subjects = strip_tags( trim( $_POST["teacher-subjects"] ) );
				$msg      = strip_tags( trim( $_POST["teacher-message"] ) );

				if ( ! isset( $name ) || strlen( $name ) == 0 ) {
					$errors['teacher-name'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^[A-Za-zÄÖÜäöü\-éèáà ]+$/', $name ) || substr_count( $name, ' ' ) < 1 ) {
					$errors['teacher-name'] = "Ungültiger Vor- und Nachname";
				}

				if ( ! isset( $email ) || strlen( $email ) == 0 ) {
					$errors['teacher-email'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $email ) > 100 ) {
					$errors["teacher-email"] = "Maximal 100 Zeichen eingeben";
				} else if ( ! is_email( $email ) ) {
					$errors["teacher-email"] = "Ungültige E-Mail";
				} else if ( substr_count( strtolower( $email ), '@franz-haniel-gymnasium.eu' ) !== 1 ) {
					$errors["teacher-email"] = "E-Mail muss franz-haniel-gymnasium.eu als Domain haben";
				}

				if ( ! isset( $subjects ) || strlen( $email ) == 0 ) {
					$errors['teacher-subjects'] = "Dies ist ein Plichtfeld";
				} else if ( strlen( $subjects ) < 5 ) {
					$errors['teacher-subjects'] = "Mindestens 5 Zeichen eingeben";
				}

				if ( ! isset( $msg ) || strlen( $msg ) == 0 ) {
					$errors['teacher-message'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $msg ) < 20 ) {
					$errors['teacher-message'] = "Mindestens 20 Zeichen eingeben";
				}

				$email_msg = "<b>Die Lehrerin/der Lehrer {$name} hat folgende Anfrage eingereicht:</b><br><br>
                      Name: {$name}<br>
                      iServ-E-Mail: {$email}<br>
                      Fächer: {$subjects}<br><br>
                      Nachricht:<br>" . nl2br( $msg );
				break;

			case "parent":
				$name       = strip_tags( trim( $_POST["parent-name"] ) );
				$name_child = strip_tags( trim( $_POST["parent-name_child"] ) );
				$email      = strip_tags( trim( $_POST["parent-email"] ) );
				$class      = strip_tags( trim( $_POST["parent-class"] ) );
				$msg        = strip_tags( trim( $_POST["parent-message"] ) );

				if ( ! isset( $name ) || strlen( $name ) == 0 ) {
					$errors['parent-name'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^[A-Za-zÄÖÜäöü\-éèáà ]+$/', $name ) || substr_count( $name, ' ' ) < 1 ) {
					$errors['parent-name'] = "Ungültiger Vor- und Nachname";
				}

				if ( ! isset( $name_child ) || strlen( $name_child ) == 0 ) {
					$errors['parent-name_child'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^[A-Za-zÄÖÜäöü\-éèáà ]+$/', $name_child ) || substr_count( $name_child, ' ' ) < 1 ) {
					$errors['parent-name_child'] = "Ungültiger Vor- und Nachname";
				}

				if ( ! isset( $email ) || strlen( $email ) == 0 ) {
					$errors['parent-email'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $email ) > 100 ) {
					$errors["parent-email"] = "Maximal 100 Zeichen eingeben";
				} else if ( ! is_email( $email ) ) {
					$errors["parent-email"] = "Ungültige E-Mail";
				} else if ( substr_count( strtolower( $email ), '@franz-haniel-gymnasium.eu' ) !== 1 ) {
					$errors["parent-email"] = "E-Mail muss franz-haniel-gymnasium.eu als Domain haben";
				}

				if ( ! isset( $class ) || strlen( $class ) == 0 ) {
					$errors['parent-class'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^([5-9][A-Ha-h]|EF|Q1|Q2)$/', $class ) ) {
					$errors['parent-class'] = "Ungültige Klasse/Stufe";
				}

				if ( ! isset( $msg ) || strlen( $msg ) == 0 ) {
					$errors['parent-message'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $msg ) < 20 ) {
					$errors['parent-message'] = "Mindestens 20 Zeichen eingeben";
				}

				$email_msg = "<b>Das Elternteil {$name} hat folgende Anfrage eingereicht:</b><br><br>
                      Name: {$name}<br>
                      Name des Kindes: {$name_child}<br>
                      iServ-E-Mail des Kindes: {$email}<br>
                      Klasse/Stufe des Kindes: {$class}<br><br>
                      Nachricht:<br>" . nl2br( $msg );
				break;

			case "principal":
				$name  = strip_tags( trim( $_POST["principal-name"] ) );
				$email = strip_tags( trim( $_POST["principal-email"] ) );
				$role  = strip_tags( trim( $_POST["principal-role"] ) );
				$msg   = strip_tags( trim( $_POST["principal-message"] ) );

				if ( ! isset( $name ) || strlen( $name ) == 0 ) {
					$errors['principal-name'] = "Dies ist ein Pflichtfeld";
				} else if ( ! preg_match( '/^[A-Za-zÄÖÜäöü\-éèáà ]+$/', $name ) || substr_count( $name, ' ' ) < 1 ) {
					$errors['principal-name'] = "Ungültiger Vor- und Nachname";
				}

				if ( ! isset( $email ) || strlen( $email ) == 0 ) {
					$errors['principal-email'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $email ) > 100 ) {
					$errors["principal-email"] = "Maximal 100 Zeichen eingeben";
				} else if ( ! is_email( $email ) ) {
					$errors["principal-email"] = "Ungültige E-Mail";
				} else if ( substr_count( strtolower( $email ), '@franz-haniel-gymnasium.eu' ) !== 1 ) {
					$errors["principal-email"] = "E-Mail muss franz-haniel-gymnasium.eu als Domain haben";
				}

				if ( ! isset( $role ) || strlen( $role ) == 0 ) {
					$errors['principal-role'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $role ) < 5 ) {
					$errors['principal-role'] = "Mindestens 5 Zeichen eingeben";
				}

				if ( ! isset( $msg ) || strlen( $msg ) == 0 ) {
					$errors['principal-message'] = "Dies ist ein Pflichtfeld";
				} else if ( strlen( $msg ) < 20 ) {
					$errors['principal-message'] = "Mindestens 20 Zeichen eingeben";
				}

				$email_msg = "<b>{$name} hat als Teil der Schulleitung folgende Anfrage eingereicht:</b><br><br>
                      Name: {$name}<br>
                      iServ-E-Mail: {$email}<br>
                      Bereich: {$role}<br><br>
                      Nachricht:<br>" . nl2br( $msg );
				break;
		}

		if ( count( $errors ) === 0 ) {
			if ( ! wp_mail( ADMIN_EMAIL_ADDRESS, "Anfrage zur Account-Freischaltung",
				"Benutzerdaten:<br><br>
                  ID: " . get_current_user_id() . "<br>
                  Angezeigter Name: " . wp_get_current_user()->display_name . "<br>
                  Login Name: " . wp_get_current_user()->user_login . "<br>
                  E-Mail: " . wp_get_current_user()->user_email . "<br>
                  Weitere Benutzerdaten (für Experten): <br><code>" . var_export( wp_get_current_user()->data, true ) . "</code><br><br>
                  {$email_msg}", array( 'Content-Type: text/html; charset=UTF-8' ) ) ) {
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
                      Mithilfe dieses Formulars kannst du dein Konto zum Beiträge Verfassen freischalten.
					<?php else:
						echo strip_tags( get_the_content(), '<a><span><br>' );
					endif; ?>
                </p>
              </div>
              <form method="POST" novalidate>
				  <?php if ( isset( $_REQUEST['success'] ) ): ?>
            <div class="success">
              <img src="<?php echo get_theme_file_uri('/img/undraw/order_confirmed.svg'); ?>" alt="Anfrage gesendet">
              <h3>Deine Anfrage wurde an uns übermittelt</h3>
              <p>Der Überprüfungsvorgang kann ein paar Tage dauern. Behalte solange dein E-Mail-Postfach im Auge.</p>
            </div>
				  <?php elseif ( is_user_logged_in() ): ?>
					  <?php wp_nonce_field( 'your-contribution_' . get_current_user_id() ); ?>
                    <div class="type select">
                      <label for="type" class="label">Ich bin</label>
                      <label class="styledSelect">
                        <select id="type" name="type">
                          <option <?php echo( $_POST["type"] === "student" ? "selected" : "" ) ?> value="student">
                            Schüler
                          </option>
                          <option <?php echo( $_POST["type"] === "teacher" ? "selected" : "" ) ?> value="teacher">
                            Lehrer
                          </option>
                          <option <?php echo( $_POST["type"] === "parent" ? "selected" : "" ) ?> value="parent">
                            Elternteil
                          </option>
                          <option <?php echo( $_POST["type"] === "principal" ? "selected" : "" ) ?> value="principal">
                            Teil der Schulleitung
                          </option>
                        </select>
                      </label>
                      <label for="type" class="error"></label>
                    </div>
                    <div class="changeable">
                      <div class="student">
                        <div class="name input <?php echo( ! empty( $errors['student-name'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="student-name" id="student-name" placeholder="Maximilian Mustermann"
                                 required
                                 value="<?php echo( isset( $_POST['student-name'] ) ? $_POST['student-name'] : ( ( is_user_logged_in() && ! ( empty( wp_get_current_user()->first_name ) && empty( wp_get_current_user()->last_name ) ) ) ? wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name : "" ) ); ?>">
                          <i class="material-icons">cancel</i>
                          <label for="student-name" class="label">Vor- und Nachname</label>
                          <label for="student-name"
                                 class="error"><?php echo( ! empty( $errors['student-name'] ) ? $errors['student-name'] : "" ); ?></label>
                        </div>
                        <div
                            class="email input <?php echo( ! empty( $errors['student-email'] ) ? "isInvalid" : "" ); ?>">
                          <input type="email" name="student-email" id="student-email"
                                 placeholder="max.muster@franz-haniel-gymnasium.eu"
                                 value="<?php echo( isset( $_POST['student-email'] ) ? $_POST['student-email'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="student-email" class="label">iServ-E-Mail</label>
                          <label for="student-email"
                                 class="error"><?php echo( ! empty( $errors['student-email'] ) ? $errors['student-email'] : "" ); ?></label>
                        </div>
                        <div
                            class="class input <?php echo( ! empty( $errors['student-class'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="student-class" id="student-class" placeholder="7d / Q1"
                                 value="<?php echo( isset( $_POST['student-class'] ) ? $_POST['student-class'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="student-class" class="label">Klasse/Stufe</label>
                          <label for="student-class"
                                 class="error"><?php echo( ! empty( $errors['student-class'] ) ? $errors['student-class'] : "" ); ?></label>
                        </div>
                        <div class="age input <?php echo( ! empty( $errors['student-age'] ) ? "isInvalid" : "" ); ?>">
                          <input type="number" name="student-age" id="student-age"
                                 value="<?php echo( isset( $_POST['student-age'] ) ? $_POST['student-age'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="student-age" class="label">Alter</label>
                          <label for="student-age"
                                 class="error"><?php echo( ! empty( $errors['student-age'] ) ? $errors['student-age'] : "" ); ?></label>
                        </div>
                        <div
                            class="message input input--textarea <?php echo( ! empty( $errors['student-message'] ) ? "isInvalid" : "" ); ?>">
                      <textarea name="student-message" id="student-message"
                                placeholder="Wer bist du? Worüber möchtest du Beiträge veröffentlichen?"
                                required><?php echo( isset( $_POST['student-message'] ) ? $_POST['student-message'] : "" ); ?></textarea>
                          <label for="student-message" class="label">Nachricht</label>
                          <label for="student-message"
                                 class="error"><?php echo( ! empty( $errors['student-message'] ) ? $errors['student-message'] : "" ); ?></label>
                        </div>
                      </div>
                      <div class="teacher">
                        <div class="name input <?php echo( ! empty( $errors['teacher-name'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="teacher-name" id="teacher-name" placeholder="Maximilian Mustermann"
                                 required
                                 value="<?php echo( isset( $_POST['teacher-name'] ) ? $_POST['teacher-name'] : ( ( is_user_logged_in() && ! ( empty( wp_get_current_user()->first_name ) && empty( wp_get_current_user()->last_name ) ) ) ? wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name : "" ) ); ?>">
                          <i class="material-icons">cancel</i>
                          <label for="teacher-name" class="label">Vor- und Nachname</label>
                          <label for="teacher-name"
                                 class="error"><?php echo( ! empty( $errors['teacher-name'] ) ? $errors['teacher-name'] : "" ); ?></label>
                        </div>
                        <div
                            class="email input <?php echo( ! empty( $errors['teacher-email'] ) ? "isInvalid" : "" ); ?>">
                          <input type="email" name="teacher-email" id="teacher-email"
                                 placeholder="max.muster@franz-haniel-gymnasium.eu"
                                 value="<?php echo( isset( $_POST['teacher-email'] ) ? $_POST['teacher-email'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="teacher-email" class="label">iServ-E-Mail</label>
                          <label for="teacher-email"
                                 class="error"><?php echo( ! empty( $errors['teacher-email'] ) ? $errors['teacher-email'] : "" ); ?></label>
                        </div>
                        <div
                            class="subjects input <?php echo( ! empty( $errors['teacher-subjects'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="teacher-subjects" id="teacher-subjects"
                                 placeholder="Deutsch, Mathematik"
                                 value="<?php echo( isset( $_POST['teacher-subjects'] ) ? $_POST['teacher-subjects'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="teacher-subjects" class="label">Unterrichtende Fächer</label>
                          <label for="teacher-subjects"
                                 class="error"><?php echo( ! empty( $errors['teacher-subjects'] ) ? $errors['teacher-subjects'] : "" ); ?></label>
                        </div>
                        <div
                            class="message input input--textarea <?php echo( ! empty( $errors['teacher-message'] ) ? "isInvalid" : "" ); ?>">
                      <textarea name="teacher-message" id="teacher-message"
                                placeholder="Worüber möchten Sie Beiträge veröffentlichen?"
                                required><?php echo( isset( $_POST['teacher-message'] ) ? $_POST['teacher-message'] : "" ); ?></textarea>
                          <label for="teacher-message" class="label">Nachricht</label>
                          <label for="teacher-message"
                                 class="error"><?php echo( ! empty( $errors['teacher-message'] ) ? $errors['teacher-message'] : "" ); ?></label>
                        </div>
                      </div>
                      <div class="parent">
                        <div class="name input <?php echo( ! empty( $errors['parent-name'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="parent-name" id="parent-name" placeholder="Maximilian Mustermann"
                                 required
                                 value="<?php echo( isset( $_POST["parent-name"] ) ? $_POST["parent-name"] : ( ( is_user_logged_in() && ! ( empty( wp_get_current_user()->first_name ) && empty( wp_get_current_user()->last_name ) ) ) ? wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name : "" ) ); ?>">
                          <i class="material-icons">cancel</i>
                          <label for="parent-name" class="label">Vor- und Nachname</label>
                          <label for="parent-name"
                                 class="error"><?php echo( ! empty( $errors['parent-name'] ) ? $errors['parent-name'] : "" ); ?></label>
                        </div>
                        <div
                            class="name_child input <?php echo( ! empty( $errors['parent-name_child'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="parent-name_child" id="parent-name_child"
                                 placeholder="Maximilian Mustermann"
                                 value="<?php echo( isset( $_POST['parent-name_child'] ) ? $_POST['parent-name_child'] : "" ); ?>"
                                 required">
                          <i class="material-icons">cancel</i>
                          <label for="parent-name_child" class="label">Vor- und Nachname des Kindes auf dem FHG</label>
                          <label for="parent-name_child"
                                 class="error"><?php echo( ! empty( $errors['parent-name_child'] ) ? $errors['parent-name_child'] : "" ); ?></label>
                        </div>
                        <div
                            class="email input <?php echo( ! empty( $errors['parent-email'] ) ? "isInvalid" : "" ); ?>">
                          <input type="email" name="parent-email" id="parent-email"
                                 placeholder="max.muster@franz-haniel-gymnasium.eu"
                                 value="<?php echo( isset( $_POST['parent-email'] ) ? $_POST['parent-email'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="parent-email" class="label">iServ-E-Mail des Kindes</label>
                          <label for="parent-email"
                                 class="error"><?php echo( ! empty( $errors['parent-email'] ) ? $errors['parent-email'] : "" ); ?></label>
                        </div>
                        <div
                            class="class input <?php echo( ! empty( $errors['parent-class'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="parent-class" id="parent-class" placeholder="7d / Q1"
                                 value="<?php echo( isset( $_POST['parent-class'] ) ? $_POST['parent-class'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="parent-email" class="label">Klasse/Stufe des Kindes</label>
                          <label for="parent-email"
                                 class="error"><?php echo( ! empty( $errors['parent-class'] ) ? $errors['parent-class'] : "" ); ?></label>
                        </div>
                        <div
                            class="message input input--textarea <?php echo( ! empty( $errors['parent-message'] ) ? "isInvalid" : "" ); ?>">
                      <textarea name="parent-message" id="parent-message"
                                placeholder="Wer bist du? Worüber möchtest du Beiträge veröffentlichen?"
                                required><?php echo( isset( $_POST['parent-message'] ) ? $_POST['parent-message'] : "" ); ?></textarea>
                          <label for="parent-message" class="label">Nachricht</label>
                          <label for="parent-message"
                                 class="error"><?php echo( ! empty( $errors['parent-message'] ) ? $errors['parent-message'] : "" ); ?></label>
                        </div>
                      </div>
                      <div class="principal">
                        <div
                            class="name input <?php echo( ! empty( $errors['principal-name'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="principal-name" id="principal-name"
                                 placeholder="Maximilian Mustermann"
                                 required
                                 value="<?php echo( isset( $_POST['principal-name'] ) ? $_POST['principal-name'] : ( ( is_user_logged_in() && ! ( empty( wp_get_current_user()->first_name ) && empty( wp_get_current_user()->last_name ) ) ) ? wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name : "" ) ); ?>">
                          <i class="material-icons">cancel</i>
                          <label for="principal-name" class="label">Vor- und Nachname</label>
                          <label for="principal-name"
                                 class="error"><?php echo( ! empty( $errors['principal-name'] ) ? $errors['principal-name'] : "" ); ?></label>
                        </div>
                        <div
                            class="email input <?php echo( ! empty( $errors['principal-email'] ) ? "isInvalid" : "" ); ?>">
                          <input type="email" name="principal-email" id="principal-email"
                                 placeholder="max.muster@franz-haniel-gymnasium.eu"
                                 value="<?php echo( isset( $_POST['principal-email'] ) ? $_POST['principal-email'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="principal-email" class="label">iServ-E-Mail</label>
                          <label for="principal-email"
                                 class="error"><?php echo( ! empty( $errors['principal-email'] ) ? $errors['principal-email'] : "" ); ?></label>
                        </div>
                        <div
                            class="role input <?php echo( ! empty( $errors['principal-role'] ) ? "isInvalid" : "" ); ?>">
                          <input type="text" name="principal-role" id="principal-role" placeholder="Sekretariat"
                                 value="<?php echo( isset( $_POST['principal-role'] ) ? $_POST['principal-role'] : "" ); ?>"
                                 required>
                          <i class="material-icons">cancel</i>
                          <label for="principal-role" class="label">Bereich</label>
                          <label for="principal-role"
                                 class="error"><?php echo( ! empty( $errors['principal-role'] ) ? $errors['principal-role'] : "" ); ?></label>
                        </div>
                        <div
                            class="message input input--textarea <?php echo( ! empty( $errors['principal-message'] ) ? "isInvalid" : "" ); ?>">
                      <textarea name="principal-message" id="principal-message"
                                placeholder="Wer sind Sie? Worüber möchten Sie Beiträge veröffentlichen?"
                                required><?php echo( isset( $_POST['principal-message'] ) ? $_POST['principal-message'] : "" ); ?></textarea>
                          <label for="principal-message" class="label">Nachricht</label>
                          <label for="principal-message"
                                 class="error"><?php echo( ! empty( $errors['principal-message'] ) ? $errors['principal-message'] : "" ); ?></label>
                        </div>
                      </div>
                      <input type="submit" class="submit" value="Senden">
                    </div>
				  <?php else: ?>
                    <div class="error-login">
                      <h3>Erster Schritt</h3>
                      <a class="login button button--light"
                         href="<?php echo wp_login_url( $_SERVER['REQUEST_URI'] ) ?>">
                        <span>Anmelden</span>
                      </a>
                      <p>- oder -</p>
                      <a class="register button"
                         href="<?php echo add_query_arg( 'redirect_to', $_SERVER['REQUEST_URI'], wp_registration_url() ); ?>">
                        <span>Registrieren</span>
                      </a>
                    </div>
				  <?php endif; ?>
              </form>
            </div>
          </div>

		<?php endwhile; endif; ?>

    </div>
	  <?php get_sidebar(); ?>
  </div>

<?php get_footer(); ?>