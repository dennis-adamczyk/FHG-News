<?php
/**
 * @package fhgnewsonline
 * -- AJAX support for Like System
 */

function fhgnewsonline_like_request() {
	include_once "likeSystem.php";

	switch ( $_POST['method'] ) {
		case 'add_like_current_user':
			if ( ! isset( $_POST['post_id'] ) ) {
				return False();
			}

			$post_id = intval( $_POST['post_id'] );
			echo add_like_user( $post_id, get_current_user_id() );
			break;

		case 'remove_like_current_user':
			if ( ! isset( $_POST['post_id'] ) ) {
				return False();
			}

			$post_id = intval( $_POST['post_id'] );
			echo remove_like_user( $post_id, get_current_user_id() );
			break;

		case 'add_comment_like_current_user':
			if ( ! isset( $_POST['comment_id'] ) ) {
				return False();
			}

			$comment_id = intval( $_POST['comment_id'] );
			echo add_comment_like_user( $comment_id, get_current_user_id() );
			break;

		case 'remove_comment_like_current_user':
			if ( ! isset( $_POST['comment_id'] ) ) {
				return False();
			}

			$comment_id = intval( $_POST['comment_id'] );
			echo remove_comment_like_user( $comment_id, get_current_user_id() );
			break;
	}

	/**
	 * Echos 'false' and returns false
	 *
	 * @return bool
	 */
	function False() {
		echo 'false';

		return false;
	}

	die();
}

add_action( 'wp_ajax_nopriv_like_request', 'fhgnewsonline_like_request' );
add_action( 'wp_ajax_like_request', 'fhgnewsonline_like_request' );