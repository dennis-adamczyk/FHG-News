<?php

/**
 * @package fhgnewsonline
 */

require_once("../../../../wp-load.php");
include_once "likeSystem.php";

switch ( $_POST['method'] ) {
	case 'add_like_current_user':
		if ( !isset( $_POST['post_id'] ) || get_current_user_id() == 0 )
			return False();

		$post_id = intval($_POST['post_id']);
		echo add_like_user($post_id, get_current_user_id());
		break;

	case 'remove_like_current_user':
		if ( !isset( $_POST['post_id'] )  || get_current_user_id() == 0 )
			return False();

		$post_id = intval($_POST['post_id']);
		echo remove_like_user($post_id, get_current_user_id());
		break;

	case 'add_comment_like_current_user':
		if ( !isset( $_POST['comment_id'] )  || get_current_user_id() == 0 )
			return False();

		$comment_id = intval($_POST['comment_id']);
		echo add_comment_like_user($comment_id, get_current_user_id());
		break;

	case 'remove_comment_like_current_user':
		if ( !isset( $_POST['comment_id'] )  || get_current_user_id() == 0 )
			return False();

		$comment_id = intval($_POST['comment_id']);
		echo remove_comment_like_user($comment_id, get_current_user_id());
		break;
}

function False() {
	echo 'false';
	return false;
}