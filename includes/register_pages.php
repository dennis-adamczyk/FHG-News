<?php
/**
 * @package fhgnewsonline
 * -- Register Theme Custom Pages
 */

/**
 * Adds URL rewrite and redirect rules
 */
function fhgnewsonline_add_rewrite_rules() {
	add_rewrite_rule( '^user\/?$', 'index.php?fhgnewsonline_page_id=2&post_type=custom_post_type', 'top' );
	add_rewrite_rule( '^user\/edit?', 'index.php?fhgnewsonline_page_id=1&post_type=custom_post_type', 'top' );
	flush_rewrite_rules();
}

add_action( 'init', 'fhgnewsonline_add_rewrite_rules' );


/**
 * Sets the query variables
 *
 * @param $vars
 *
 * @return mixed
 */
function fhgnewsonline_set_query_var( $vars ) {
	array_push( $vars, 'fhgnewsonline_page_id' );

	return $vars;
}

add_action( 'query_vars', 'fhgnewsonline_set_query_var' );


/**
 * Includes PHP template files for all redirected URLs
 *
 * @param $template
 *
 * @return null|string
 */
function fhgnewsonline_include_template( $template ) {
	if ( get_query_var( 'fhgnewsonline_page_id' ) ) {
		$new_template = null;
		switch ( get_query_var( 'fhgnewsonline_page_id' ) ) {
			case 1:
				$new_template = get_template_directory() . '/pages/edit_profile.php';
				break;

			case 2:
				header('Location: ' . get_author_posts_url(get_current_user_id()));
				die();
				break;
		}

		if ( file_exists( $new_template ) ) {
			$template = $new_template;
		}
	}

	return $template;
}

add_filter( 'template_include', 'fhgnewsonline_include_template', 1000, 1 );