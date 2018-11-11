<?php
/**
 * @package fhgnewsonline
 * -- Mail Filter
 */

function fhgnewsonline_email_change_email( $email_change_email, $user, $userdata ) {
	$email_change_email['subject'] = 'E-Mail-Adresse wurde geändert';

	return $email_change_email;
}
add_filter( 'email_change_email', 'fhgnewsonline_email_change_email', 10, 3 );


function fhgnewsonline_wp_new_user_notification_email( $wp_new_user_notification_email, $user, $blogname ) {

	$wp_new_user_notification_email['subject'] = 'Konto bestätigen';

	$user_login = $user->user_login;
	$key        = get_password_reset_key( $user );

	if ( is_wp_error( $key ) ) {
		return $key;
	}

	$message = '<h1>Willkommen auf FHG News!</h1>';
	$message .= '<p>Dein Konto auf <a href="' . get_home_url() . '">FHG News</a> wurde erfolgreich erstellt. Um dich auf der Website anmelden zu können musst du auf den unten stehenden Link klicken. Es sollte sich anschließend ein Fenster öffnen, in dem du dein Passwort für dein erstelltes Konto festlegen kannst.</p>';
	$message .= '<p>Dein Benutzername lautet: <b>' . $user_login . '</b></p>';
	$message .= '<p>Klicke auf diesen Link um dein Konto zu bestätigen und dir ein Passwort auszusuchen:</p>';
	$message .= '<a class="button" href="' . network_site_url( "/login/reset-password/?change&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . '"><span>Konto bestätigen & Passwort festlegen</span></a>';

	$wp_new_user_notification_email['message'] = $message;

	return $wp_new_user_notification_email;
}
add_filter( 'wp_new_user_notification_email', 'fhgnewsonline_wp_new_user_notification_email', 10, 3 );

function fhgnewsonline_wp_new_user_notification_email_admin( $wp_new_user_notification_email, $user, $blogname ) {

	$wp_new_user_notification_email['subject'] = 'Neue Benutzerregistrierung';

	$user_login = $user->user_login;
	$user_email = $user->user_email;

	$message = '<h1>Registrierung eines neuen Benutzers!</h1>';
	$message .= '<p>Ein neuer Benutzer hat sich auf FHG News registriert.</p>';
	$message .= '<p>Benutzername: <b>' . $user_login . '</b></p>';
	$message .= '<p>E-Mail-Adresse: <b>' . $user_email . '</b></p>';

	$wp_new_user_notification_email['message'] = $message;

	return $wp_new_user_notification_email;
}
add_filter( 'wp_new_user_notification_email_admin', 'fhgnewsonline_wp_new_user_notification_email_admin', 10, 3 );