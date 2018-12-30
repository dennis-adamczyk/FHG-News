<?php
/**
 * @package fhgnewsonline
 * -- Register Theme Custom Pages
 *
 * ##### PAGE IDs #####
 * 1    - Edit Profile Page
 * 2    - Profile Page Redirect
 * 3    - Login Page
 * 4    - Registration Page
 * 5    - Reset Password Page
 * 6    - Settings Page
 */

/**
 * Adds URL rewrite and redirect rules
 */
function fhgnewsonline_add_rewrite_rules() {
	add_rewrite_rule( '^user\/?$', 'index.php?fhgnewsonline_page_id=2&post_type=custom_post_type', 'top' );
	add_rewrite_rule( '^user\/edit?', 'index.php?fhgnewsonline_page_id=1&post_type=custom_post_type', 'top' );
	add_rewrite_rule( '^user\/settings?', 'index.php?fhgnewsonline_page_id=6&post_type=custom_post_type', 'top' );
	add_rewrite_rule( '^login\/?$', 'index.php?fhgnewsonline_page_id=3&post_type=custom_post_type', 'top' );
	add_rewrite_rule( '^login\/register?', 'index.php?fhgnewsonline_page_id=4&post_type=custom_post_type', 'top' );
	add_rewrite_rule( '^login\/reset-password?', 'index.php?fhgnewsonline_page_id=5&post_type=custom_post_type', 'top' );
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
				header( 'Location: ' . get_author_posts_url( get_current_user_id() ) );
				die();
				break;

			case 3:
				$new_template = get_template_directory() . '/pages/login.php';
				break;

			case 4:
				$new_template = get_template_directory() . '/pages/register.php';
				break;

			case 5:
				$new_template = get_template_directory() . '/pages/reset_password.php';
				break;

			case 6:
				$new_template = get_template_directory() . '/pages/settings.php';
				break;
		}

		if ( file_exists( $new_template ) ) {
			$template = $new_template;
		}
	}

	return $template;
}

add_filter( 'template_include', 'fhgnewsonline_include_template', 1000, 1 );


/* LOGIN PAGE */

add_filter( 'login_url', 'login_page_url', 999, 3 );

function login_page_url( $login_url, $redirect, $force_reauth ) {
	$login_page = home_url( '/login/' );
	$login_url  = ! empty( $redirect ) ? add_query_arg( 'redirect_to', $redirect, $login_page ) : $login_page;

	return $login_url;
}

add_filter( 'logout_url', 'logout_page_url', 999, 2 );

function logout_page_url( $logout_url, $redirect ) {
	$logout_page = home_url( '/login/?logout' );
	$logout_url  = ! empty( $redirect ) ? add_query_arg( 'redirect_to', $redirect, $logout_page ) : $logout_page;

	return $logout_url;
}

add_filter( 'register_url', 'register_page_url', 999, 1 );

function register_page_url( $register_url ) {
	return home_url( '/login/register/' );
}

/* RESET PASSWORD PAGE */

add_filter( 'lostpassword_url', 'reset_password_page', 999, 2 );
function reset_password_page( $lostpassword_url, $redirect ) {
	$lostpassword_page = home_url( '/login/reset-password/' );
	$lostpassword_url  = ! empty( $redirect ) ? add_query_arg( 'redirect_to', $redirect, $lostpassword_page ) : $lostpassword_page;

	return $lostpassword_url;
}

/* EDIT PROFILE PAGE */

add_filter( 'edit_profile_url', 'edit_profile_page_url', 10, 3 );

function edit_profile_page_url( $url, $user_id, $scheme ) {
	return home_url( '/user/edit/' );
}

add_action( 'admin_menu', 'admin_menu_edit_profile_page_link', 99 );
function admin_menu_edit_profile_page_link() {
	global $menu, $submenu;
	if ( ! current_user_can( 'list_users' ) ) {
		$menu[70] = array(
			__( 'Profile' ),
			'read',
			get_edit_profile_url(),
			'',
			'menu-top menu-icon-users',
			'menu-users',
			'dashicons-admin-users'
		);
	}
}