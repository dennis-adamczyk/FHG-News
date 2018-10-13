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