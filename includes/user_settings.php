<?php
/*
 * @package fhgnewsonline
 * -- User Settings
 */

const REMEMBER_ME_SETTINGS_KEY = "settings-remember_me";
const PUSH_NOTIFICATIONS_SETTINGS_KEY = "settings-push_notifications";
const EMAIL_NEWSLETTER_SETTINGS_KEY = "settings-email_newsletter";

/**
 * @param string $settingsname Name of setting
 * @param string $type type of value
 * @param int|null $user_id User ID or null for current user
 *
 * @return mixed user settings value or false on failure
 */
function get_setting( $settingsname, $type = null, $user_id = null ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	$result = get_user_meta( $user_id, $settingsname, true );
	switch ( $type ) {
		case 'string':
			return (string) $result;
			break;
		case 'int':
			return intval( $result );
			break;
		case 'bool':
		case 'boolean':
			return filter_var( $result, FILTER_VALIDATE_BOOLEAN );
			break;
		case 'array':
			return (array) $result;
			break;
		default:
			return $result;
			break;
	}
}

/**
 * @param string $settingsname Name of setting
 * @param mixed $value Value to set
 * @param int|null $user_id User ID or null for current user
 *
 * @return false|int User meta ID on success or false on failure
 */
function set_setting( $settingsname, $value, $user_id = null ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	return update_user_meta( $user_id, $settingsname, $value );
}

function fhgnewsonline_set_default_settings( $user_id ) {
	set_setting( REMEMBER_ME_SETTINGS_KEY, true, $user_id );
	set_setting( PUSH_NOTIFICATIONS_SETTINGS_KEY, false, $user_id );
	set_setting( EMAIL_NEWSLETTER_SETTINGS_KEY, false, $user_id );
}

add_action( 'user_register', 'fhgnewsonline_set_default_settings', 10, 1 );

function fhgnewsonline_expiration_filter( $seconds, $user_id, $remember ) {

	if ( get_setting( REMEMBER_ME_SETTINGS_KEY, 'bool' ) ) {
		$expiration = 30 * 24 * 60 * 60; // 30 days
	} else {
		$expiration = 2 * 24 * 60 * 60; // 2 days
	}

	return $expiration;
}

add_filter( 'auth_cookie_expiration', 'fhgnewsonline_expiration_filter', 99, 3 );

function fhgnewsonline_ajax_set_setting() {
	$settingsname = $_POST["settingsname"];
	$value        = $_POST["value"];
	$user_id      = $_POST["user_id"];
	if ( ! isset( $settingsname ) || ! isset( $value ) ) {
		echo "false";
		die();
	}

	echo set_setting( $settingsname, $value, isset( $user_id ) ? $user_id : null );
	die();
}

add_action( 'wp_ajax_set_setting', 'fhgnewsonline_ajax_set_setting' );
add_action( 'wp_ajax_nopriv_set_setting', 'fhgnewsonline_ajax_set_setting' );
