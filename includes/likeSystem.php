<?php
/**
 * @package fhgnewsonline
 * -- Like System
 */

/*
 * ===============================
 *      POSTS
 * ===============================
 */

const LIKE_DB_KEY = 'user_like';

/**
 * Getter for Array of User IDs that liked the post
 *
 * @param int $post_id ID of Post
 *
 * @return array|false Array with User IDs or false when no one has liked
 */
function get_like_users( $post_id ) {
	return get_post_meta( $post_id, LIKE_DB_KEY, false ) ?: false;
}

/**
 * Getter for Amount of Likes of a post
 *
 * @param int $post_id ID of Post
 *
 * @return int Like Amount
 */
function get_like_amount( $post_id ) {
	return count( get_post_meta( $post_id, LIKE_DB_KEY, false ) ) ?: 0;
}

/**
 * Adds a Like to a Post with User ID
 *
 * @param int $post_id ID of Post
 * @param int $user_id ID of User
 *
 * @return int|false Meta ID on success, false on failure
 */
function add_like_user( $post_id, $user_id ) {
	return ! has_liked( $post_id, $user_id ) ? add_post_meta( $post_id, LIKE_DB_KEY, $user_id, false ) : false;
}

/**
 * Removes a Like from a Post with User ID
 *
 * @param int $post_id ID of Post
 * @param int $user_id ID of User
 *
 * @return bool False for failure, true for success
 */
function remove_like_user( $post_id, $user_id ) {
	return delete_post_meta( $post_id, LIKE_DB_KEY, $user_id );
}

/**
 * Returns if a User has liked a Post
 *
 * @param int $post_id ID of Post
 * @param int $user_id ID of User
 *
 * @return bool True for User liked Post, False for don't liked
 */
function has_liked( $post_id, $user_id ) {
	if ( $user_id == 0 ) {
		$user_id = implode( ':', str_split( md5( $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] ), 4 ) );
	}

	return array_search( ( $user_id ), get_post_meta( $post_id, LIKE_DB_KEY, false ) ) !== false;
}


/*
 * ===============================
 *      COMMENTS
 * ===============================
 */

const COMMENT_LIKE_DB_KEY = 'user_like';

/**
 * Getter for Array of User IDs that liked the comment
 *
 * @param int $comment_id ID of Comment
 *
 * @return array|false Array with User IDs or false when no one has liked
 */
function get_comment_like_users( $comment_id ) {
	return get_comment_meta( $comment_id, COMMENT_LIKE_DB_KEY, false ) ?: false;
}

/**
 * Getter for Amount of Likes of a Comment
 *
 * @param int $comment_id ID of Comment
 *
 * @return int Like Amount
 */
function get_comment_like_amount( $comment_id ) {
	return count( get_comment_meta( $comment_id, COMMENT_LIKE_DB_KEY, false ) ) ?: 0;
}

/**
 * Adds a Like to a Comment with User ID
 *
 * @param int $comment_id ID of Comment
 * @param int $user_id ID of User
 *
 * @return int|false Meta ID on success, false on failure
 */
function add_comment_like_user( $comment_id, $user_id ) {
	return ! has_liked_comment( $comment_id, $user_id ) ? add_comment_meta( $comment_id, COMMENT_LIKE_DB_KEY, $user_id, false ) : false;
}

/**
 * Removes a Like from a Comment with User ID
 *
 * @param int $comment_id ID of Comment
 * @param int $user_id ID of User
 *
 * @return bool False for failure, true for success
 */
function remove_comment_like_user( $comment_id, $user_id ) {
	return delete_comment_meta( $comment_id, COMMENT_LIKE_DB_KEY, $user_id );
}

/**
 * Returns if a User has liked a Comment
 *
 * @param int $comment_id ID of Comment
 * @param int $user_id ID of User
 *
 * @return bool True for User liked Comment, False for don't liked
 */
function has_liked_comment( $comment_id, $user_id ) {
	if ( $user_id == 0 ) {
		$user_id = implode( ':', str_split( md5( $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'] ), 4 ) );
	}

	return array_search( $user_id, get_comment_meta( $comment_id, COMMENT_LIKE_DB_KEY, false ) ) !== false;
}
