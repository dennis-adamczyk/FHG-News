<?php
/**
 * @package fhgnewsonline
 * -- Profile Picture System
 */

/**
 * Sets the profile picture of a user
 *
 * @param int|null $user_id User ID or null for current user
 * @param string $image base64
 */
function set_profile_picture( $user_id, $image ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}
	$image = base64_decode($image);
}