<?php
/**
 * @package fhgnewsonline
 * -- Shortcodes
 */

function fhgnewsonline_ar_antwort_shortcode( $atts, $content, $tag ) {
	global $post;

	$atts = shortcode_atts( array(
		'code' => null
	), $atts );

	if ( ! empty( $_POST ) && $_REQUEST['ar_antwort'] == $atts['code'] && ! $_REQUEST['ar_success'] == $atts['code'] ) {
		$script = '';

		$errors = array();

		$name   = strip_tags( trim( $_POST["full_name"] ) );
		$email  = strip_tags( trim( $_POST["email"] ) );
		$class  = strip_tags( trim( $_POST["class"] ) );
		$answer = strip_tags( trim( $_POST["answer"] ) );

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

		if ( ! isset( $class ) || strlen( $class ) == 0 ) {
			$errors['class'] = "Dies ist ein Pflichtfeld";
		} else if ( ! preg_match( '/^([5-9][A-Ha-h]|EF|Q1|Q2)$/', strtoupper( $class ) ) ) {
			$errors['class'] = "Ungültige Klasse/Stufe";
		}

		if ( ! isset( $answer ) || strlen( $answer ) == 0 ) {
			$errors['answer'] = "Dies ist ein Pflichtfeld";
		} else if ( strlen( $answer ) < 1 ) {
			$errors['answer'] = "Mindestens 1 Zeichen eingeben";
		}

		if ( count( $errors ) === 0 ) {
			if ( ! wp_mail( get_option( 'admin_email' ), "[Adventsrätsel] Neue Lösung für Rätsel #" . $_REQUEST['ar_antwort'],
				"<h1>{$name} hat folgende Lösung übermittelt</h1><br><br>
                  <p><b>Rätsel Code:</b> {$atts['code']}</p>
                  <p><b>Benutzerdaten (für Experten):</b><br>
                  <code>" . var_export( wp_get_current_user()->data, true ) . "</code></p>
                  <p><b>Name:</b> {$name}</p>
                  <p><b>E-Mail:</b> {$email}</p>
                  <p><b>Klasse/Stufe:</b> {$class}</p>
                  <p><b>Lösung:</b><br>" . nl2br( $answer ) . "</p>", array( 'Content-Type: text/html; charset=UTF-8' ) ) ) {
				$script = "showSingleLineSnackBar('Fehler aufgetreten. Versuch es später erneut');";
			} else {
				$script = "window.location.replace('?ar_success=" . $_REQUEST['ar_antwort'] . "');";
			}
		}
	}

	ob_start(); ?>
  <script><?php echo $script; ?></script>
  <form method="post" action="?ar_antwort=<?php echo $atts['code']; ?>" class="ar_antwort">
	  <?php if ( isset( $_REQUEST['ar_success'] ) && $_REQUEST['ar_success'] == $atts['code'] ): ?>
        <div class="success">
          <img src="<?php echo get_theme_file_uri( '/img/undraw/order_confirmed.svg' ); ?>"
               alt="Lösung gesendet">
          <h3>Deine Lösung wurde an uns übermittelt</h3>
          <p>Falls die Antwort richtig war und du gewonnen hast, senden wir dir morgen eine E-Mail. Behalte also dein
            Postfach im Auge.</p>
        </div>
	  <?php else: ?>
        <div class="full_name input <?php echo( ! empty( $errors['full_name'] ) ? "isInvalid" : "" ); ?>">
          <input type="text" name="full_name" id="full_name" placeholder="Maximilian Mustermann"
                 value="<?php echo( isset( $_POST['full_name'] ) ? $_POST['full_name'] : ( ( is_user_logged_in() && ! ( empty( wp_get_current_user()->first_name ) && empty( wp_get_current_user()->last_name ) ) ) ? wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name : "" ) ); ?>"
                 required>
          <i class="material-icons">cancel</i>
          <label for="full_name" class="label">Vor- & Nachname</label>
          <label for="full_name"
                 class="error"><?php echo( ! empty( $errors['full_name'] ) ? $errors['full_name'] : "" ); ?></label>
        </div>
        <div
            class="email input <?php echo( ! empty( $errors['email'] ) ? "isInvalid" : "" ); ?>">
          <input type="email" name="email" id="email"
                 placeholder="max.muster@franz-haniel-gymnasium.eu"
                 value="<?php echo( isset( $_POST['email'] ) ? $_POST['email'] : ( ( is_user_logged_in() && ! empty( wp_get_current_user()->user_email ) ? wp_get_current_user()->user_email : "" ) ) ); ?>"
                 required>
          <i class="material-icons">cancel</i>
          <label for="email" class="label">E-Mail</label>
          <label for="email" class="error"><?php echo( ! empty( $errors['email'] ) ? $errors['email'] : "" ); ?></label>
        </div>
        <div class="class input <?php echo( ! empty( $errors['class'] ) ? "isInvalid" : "" ); ?>">
          <input type="text" name="class" id="class" placeholder="7d / Q1"
                 value="<?php echo( isset( $_POST['class'] ) ? $_POST['class'] : "" ); ?>" required>
          <i class="material-icons">cancel</i>
          <label for="class" class="label">Klasse / Stufe</label>
          <label for="class"
                 class="error"><?php echo( ! empty( $errors['class'] ) ? $errors['class'] : "" ); ?></label>
        </div>
        <div class="answer input input--textarea <?php echo( ! empty( $errors['answer'] ) ? "isInvalid" : "" ); ?>">
      <textarea name="answer" id="answer"
                required><?php echo( isset( $_POST['answer'] ) ? $_POST['answer'] : "" ); ?></textarea>
          <i class="material-icons">cancel</i>
          <label for="answer" class="label">Lösung</label>
          <label for="answer"
                 class="error"><?php echo( ! empty( $errors['answer'] ) ? $errors['answer'] : "" ); ?></label>
        </div>
        <input type="submit" class="submit" value="Lösung einreichen">
	  <?php endif; ?>
  </form>
	<?php
	return ob_get_clean();
}

add_shortcode( 'ar_antwort', 'fhgnewsonline_ar_antwort_shortcode' );