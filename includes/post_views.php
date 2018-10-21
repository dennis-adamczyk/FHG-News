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
		setcookie( VIEWED_POSTS_COOKIE, json_encode( $viewed_posts ), time() + 60 * 60 * 24, '/' );

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


function fhgnewsonline_add_post_views_when_publish_post( $ID, $post ) {
	if ( empty( get_post_views( $ID ) ) ) {
		set_post_views( $ID, 0 );
	}
}

add_action( 'publish_post', 'fhgnewsonline_add_post_views_when_publish_post', 10, 2 );


function fhgnewsonline_columns_head( $defaults ) {
	$defaults['post_views'] = "Klicks";

	return $defaults;
}

add_filter( 'manage_posts_columns', 'fhgnewsonline_columns_head' );

function fhgnewsonline_columns_content( $column_name, $post_ID ) {
	if ( $column_name == 'post_views' ) {
		$post_views = get_post_views( $post_ID );
		echo number_format( (int) ( $post_views ? $post_views : 0 ), 0, ',', '.' ) . " Aufrufe";
	}
}

add_action( 'manage_posts_custom_column', 'fhgnewsonline_columns_content', 10, 2 );

function fhgnewsonline_sortable_column( $columns ) {
	$columns['post_views'] = array( "post_views", true );

	return $columns;
}

add_filter( 'manage_edit-post_sortable_columns', 'fhgnewsonline_sortable_column' );

function fhgnewsonline_post_views_orderby( $query ) {
	if ( ! is_admin() ) {
		return;
	}

	$orderby = $query->get( 'orderby' );

	if ( 'post_views' == $orderby ) {
		$query->set( 'meta_key', 'fhgnewsonline_post_views' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}

add_action( 'pre_get_posts', 'fhgnewsonline_post_views_orderby' );
