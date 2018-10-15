<?php
/**
 * @package fhgnewsonline
 * -- Ajax Functions
 */


/*
 * ===============================
 *      SOCIAL MEDIA
 * ===============================
 */

const FACEBOOK_URL_DB_KEY  = 'user_facebook';
const TWITTER_URL_DB_KEY   = 'user_twitter';
const INSTAGRAM_URL_DB_KEY = 'user_instagram';
const SNAPCHAT_URL_DB_KEY  = 'user_snapchat';

const FACEBOOK_PRE_URL  = 'https://www.facebook.com/';
const TWITTER_PRE_URL   = 'https://twitter.com/';
const INSTAGRAM_PRE_URL = 'https://www.instagram.com/';
const SNAPCHAT_PRE_URL  = 'https://www.snapchat.com/add/';

/**
 * Sets the Facebook link of an user
 *
 * @param int $user_id User ID
 * @param string $url Facebook Link
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_facebook_url( $user_id, $url ) {
	return update_user_meta( $user_id, FACEBOOK_URL_DB_KEY, $url );
}

/**
 * Sets the Twitter link of an user
 *
 * @param int $user_id User ID
 * @param string $url Twitter Link
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_twitter_url( $user_id, $url ) {
	return update_user_meta( $user_id, TWITTER_URL_DB_KEY, $url );
}

/**
 * Sets the Instagram link of an user
 *
 * @param int $user_id User ID
 * @param string $url Instagram Link
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_instagram_url( $user_id, $url ) {
	return update_user_meta( $user_id, INSTAGRAM_URL_DB_KEY, $url );
}

/**
 * Sets the Snapchat link of an user
 *
 * @param int $user_id User ID
 * @param string $url Snapchat Link
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_snapchat_url( $user_id, $url ) {
	return update_user_meta( $user_id, SNAPCHAT_URL_DB_KEY, $url );
}


/**
 * Sets the Facebook name of an user
 *
 * @param int $user_id User ID
 * @param string $name Username
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_facebook_name( $user_id, $name ) {
	return $name === '' ? set_facebook_url( $user_id, '' ) : set_facebook_url( $user_id, FACEBOOK_PRE_URL . $name );
}

/**
 * Sets the Twitter name of an user
 *
 * @param int $user_id User ID
 * @param string $name Username
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_twitter_name( $user_id, $name ) {
	return $name === '' ? set_twitter_url( $user_id, '' ) : set_twitter_url( $user_id, TWITTER_PRE_URL . $name );
}

/**
 * Sets the Instagram name of an user
 *
 * @param int $user_id User ID
 * @param string $name Username
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_instagram_name( $user_id, $name ) {
	return $name === '' ? set_instagram_url( $user_id, '' ) : set_instagram_url( $user_id, INSTAGRAM_PRE_URL . $name );
}

/**
 * Sets the Snapchat name of an user
 *
 * @param int $user_id User ID
 * @param string $name Username
 *
 * @return bool|int Meta ID if the key didn't exist; true on successful update; false on failure or if $meta_value is the same as the existing meta value in the database.
 */
function set_snapchat_name( $user_id, $name ) {
	return $name === '' ? set_snapchat_url( $user_id, '' ) : set_snapchat_url( $user_id, SNAPCHAT_PRE_URL . $name );
}


/**
 * Gets the Facebook link of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_facebook_url( $user_id ) {
	return get_user_meta( $user_id, FACEBOOK_URL_DB_KEY, true );
}

/**
 * Gets the Twitter link of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_twitter_url( $user_id ) {
	return get_user_meta( $user_id, TWITTER_URL_DB_KEY, true );
}

/**
 * Gets the Instagram link of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_instagram_url( $user_id ) {
	return get_user_meta( $user_id, INSTAGRAM_URL_DB_KEY, true );
}

/**
 * Gets the Snapchat link of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_snapchat_url( $user_id ) {
	return get_user_meta( $user_id, SNAPCHAT_URL_DB_KEY, true );
}


/**
 * Gets the Facebook name of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_facebook_name( $user_id = null ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	return substr( get_facebook_url( $user_id ), strlen( FACEBOOK_PRE_URL ) );
}

/**
 * Gets the Twitter name of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_twitter_name( $user_id = null ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	return substr( get_twitter_url( $user_id ), strlen( TWITTER_PRE_URL ) );
}

/**
 * Gets the Instagram name of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_instagram_name( $user_id = null ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	return substr( get_instagram_url( $user_id ), strlen( INSTAGRAM_PRE_URL ) );
}

/**
 * Gets the Snapchat name of an user
 *
 * @param int $user_id User ID
 *
 * @return string Value of meta_key field
 */
function get_snapchat_name( $user_id = null ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	return substr( get_snapchat_url( $user_id ), strlen( SNAPCHAT_PRE_URL ) );
}


/**
 * Deletes the Facebook link of an user
 *
 * @param int $user_id User ID
 *
 * @return bool Success
 */
function delete_facebook_url( $user_id ) {
	return delete_user_meta( $user_id, FACEBOOK_URL_DB_KEY );
}

/**
 * Deletes the Twitter link of an user
 *
 * @param int $user_id User ID
 *
 * @return bool Success
 */
function delete_twitter_url( $user_id ) {
	return delete_user_meta( $user_id, TWITTER_URL_DB_KEY );
}

/**
 * Deletes the Instagram link of an user
 *
 * @param int $user_id User ID
 *
 * @return bool Success
 */
function delete_instagram_url( $user_id ) {
	return delete_user_meta( $user_id, INSTAGRAM_URL_DB_KEY );
}

/**
 * Deletes the Snapchat link of an user
 *
 * @param int $user_id User ID
 *
 * @return bool Success
 */
function delete_snapchat_url( $user_id ) {
	return delete_user_meta( $user_id, SNAPCHAT_URL_DB_KEY );
}