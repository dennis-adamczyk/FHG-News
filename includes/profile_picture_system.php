<?php
/**
 * @package fhgnewsonline
 * -- Profile Picture System
 */

const PROFILE_PICTURE_PATH   = ABSPATH . "/wp-content/profile-pictures/";
const PROFILE_PICTURE_FOLDER = "/wp-content/profile-pictures/";

/**
 * Initializes profile pictures
 */
function profile_picture_init() {
	if ( ! file_exists( PROFILE_PICTURE_PATH ) ) {
		mkdir( PROFILE_PICTURE_PATH, 0777, true );
	}
}

/**
 * Sets the profile picture of a user
 *
 * @param int|null $user_id User ID or null for current user
 * @param string $image in canvas form
 *
 * @return false|int Amount if written bytes or false
 * @throws Exception
 */
function set_profile_picture( $user_id, $image ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	if ( preg_match( '/^data:image\/(\w+);base64,/', $image, $type ) ) {
		$image = substr( $image, strpos( $image, ',' ) + 1 );
		$type  = strtolower( $type[1] ); // jpg, png, gif

		if ( ! in_array( $type, [ 'png' ] ) ) {
			throw new \Exception( 'invalid image type' );
		}

		$image = base64_decode( $image );

		if ( $image === false ) {
			throw new \Exception( 'base64_decode failed' );
		}
	} else {
		throw new \Exception( 'did not match data URI with image data' );
	}

	$imageName = $user_id . '.png';

	return file_put_contents( PROFILE_PICTURE_PATH . $imageName, $image );
}

/**
 * Deletes the profile picture of a user
 *
 * @param int|null $user_id User ID or null for current user
 *
 * @return bool Success
 */
function delete_profile_picture( $user_id ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	$imageName = $user_id . '.png';
	if ( file_exists( PROFILE_PICTURE_PATH . $imageName ) ) {
		return unlink( PROFILE_PICTURE_PATH . $imageName );
	}

	return true;
}

/**
 * Gets profile picture url
 *
 * @param int|null $user_id User ID or null for current user
 *
 * @return string Profile Picture Url
 */
function get_profile_picture_url( $user_id ) {
	if ( $user_id === null ) {
		$user_id = get_current_user_id();
	}

	return get_home_url() . PROFILE_PICTURE_FOLDER . $user_id . '.png';
}

add_filter( 'get_avatar', 'fhgnewsonline_get_avatar', 10, 5 );

function fhgnewsonline_get_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
	$user = false;
	$id   = false;

	if ( is_numeric( $id_or_email ) ) {
		$id   = (int) $id_or_email;
		$user = get_user_by( 'id', $id );
	} elseif ( is_object( $id_or_email ) ) {
		if ( ! empty( $id_or_email->ID ) ) {
			$id   = (int) $id_or_email->ID;
			$user = get_user_by( 'id', $id );
		}
	} else {
		$user = get_user_by( 'email', $id_or_email );
		$id   = $user->ID;
	}

	if ( $user && is_object( $user ) ) {

		$filePath = PROFILE_PICTURE_PATH . $id . '.png';
		$fileURL  = get_profile_picture_url( $id );
		if ( file_exists( $filePath ) ) {
			$avatar = "<img alt='{$alt}' src='{$fileURL}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
		}

	}

	return $avatar;
}

add_filter( 'get_avatar_url', 'fhgnewsonline_get_avatar_url', 10, 3 );

function fhgnewsonline_get_avatar_url( $url, $id_or_email, $args ) {
	$user = false;
	$id   = false;

	if ( is_numeric( $id_or_email ) ) {
		$id   = (int) $id_or_email;
		$user = get_user_by( 'id', $id );
	} elseif ( is_object( $id_or_email ) ) {
		if ( ! empty( $id_or_email->ID ) ) {
			$id   = (int) $id_or_email->ID;
			$user = get_user_by( 'id', $id );
		}
	} else {
		$user = get_user_by( 'email', $id_or_email );
		$id   = $user->ID;
	}

	if ( $user && is_object( $user ) ) {

		$filePath = PROFILE_PICTURE_PATH . $id . '.png';
		$fileURL  = get_profile_picture_url( $id );
		if ( file_exists( $filePath ) ) {
			$url = $fileURL;
		}

	}

	return $url;
}