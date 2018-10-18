<?php
/**
 * @package fhgnewsonline
 * -- Post Views
 */

const POST_VIEWS_DB_KEY   = 'fhgnewsonline_post_views';
const VIEWED_POSTS_COOKIE = 'viewed_posts';

function add_post_view( $post_id ) {
	$viewed_posts = empty( $_COOKIE["viewed_posts"] ) ? array() : json_decode( $_COOKIE["viewed_posts"] );
	if ( ! in_array( $post_id, $viewed_posts ) ) {
		$views = (int) ( empty( get_post_views( $post_id ) ) ? 1 : get_post_views( $post_id ) + 1 );
		array_push( $viewed_posts, $post_id );
		setcookie( VIEWED_POSTS_COOKIE, json_encode( $viewed_posts ), time() + 60 * 60 * 24 * 30, '/' );

		return set_post_views( $post_id, $views );
	}

	return false;
}

function set_post_views( $post_id, $view_count ) {
	return update_post_meta( $post_id, POST_VIEWS_DB_KEY, $view_count );
}

function get_post_views( $post_id ) {
	return get_post_meta( $post_id, POST_VIEWS_DB_KEY, true );
}


remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );