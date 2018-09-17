<?php
/**
 * @package fhgnewsonline
 */

require get_template_directory() . "/includes/sidebar.php";
require get_template_directory() . "/includes/widgets.php";

/*
 * Embedded styles and scripts
 */

function fhgnewsonline_enqueue() {
	wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css' );
	wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
	wp_enqueue_style( 'roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,500,600' );
	wp_enqueue_style( 'waves', get_template_directory_uri() . '/css/waves.min.css' );
	wp_enqueue_script( 'waves', get_template_directory_uri() . '/js/waves.min.js' );
	wp_enqueue_script( 'app', get_template_directory_uri() . '/js/app.js', array( 'jquery' ) );
	wp_localize_script( 'app', 'php_info', array(
		'template_directory_uri' => get_template_directory_uri(),
		'home_url'               => get_home_url(),
		'admin_url'              => get_admin_url(),
	) );

	if ( is_home() ) {
		wp_enqueue_style( 'blog', get_template_directory_uri() . '/css/blog.css' );
	}
	if ( is_single() ) {
		wp_enqueue_style( 'single', get_template_directory_uri() . '/css/single.css' );
		wp_enqueue_script( 'single', get_template_directory_uri() . '/js/single.js' );
		wp_localize_script( 'single', 'php_vars', array( 'login_url' => wp_login_url(), 'post_id' => get_the_ID() ) );
	}
	if ( is_page() ) {
		wp_enqueue_style( 'page', get_template_directory_uri() . '/css/page.css' );
		if ( is_page( 'about' ) ) {
			wp_enqueue_style( 'page-about', get_template_directory_uri() . '/css/page-about.css' );
		}
	}
	if ( is_search() ) {
		wp_enqueue_style( 'search', get_template_directory_uri() . '/css/search.css' );
	}
}

add_action( 'wp_enqueue_scripts', 'fhgnewsonline_enqueue' );

/*
 * Setup function of theme
 */
function fhgnewsonline_theme_setup() {
	add_theme_support( 'menus' );
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'quote', 'status', 'video', 'audio' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

	set_post_thumbnail_size( 1920, 1080, array( 'center', 'center' ) );

	register_nav_menu( 'primary', 'Webseiten-Navigation' );

	update_option( 'comment_registration', 1, true );
	update_option( 'users_can_register', 1, true );
	update_option( 'comment_order', 'desc', true );
	update_option( 'comment_whitelist', 0, true );
	update_option( 'page_comments', '', true );
	update_option( 'thread_comments', 1, true );
	update_option( 'thread_comments_depth', 2, true );
	update_option( 'permalink_structure', '/%year%/%monthnum%/%day%/%postname%/', true );

	create_page_if_not_exists('about', 'Über Uns');
	create_page_if_not_exists('your-contribution', 'Dein Beitrag');
	create_page_if_not_exists('contact', 'Kontakt');
	create_page_if_not_exists('imprint', 'Impressum');
	create_page_if_not_exists('privacy', 'Datenschutz');

	include "includes/appbar.php";
	include "includes/likeSystem.php";
	include "includes/comment_format.php";
}

add_action( 'init', 'fhgnewsonline_theme_setup' );

/**
 * Get title of current page
 * @return string page_title
 */
function fhgnewsonline_get_page_title() {
	return ( explode( ' &#8211;', get_wp_title_rss() )[0] == get_bloginfo_rss( 'name' ) || is_single() ? 'News' : explode( '&#8211;', get_wp_title_rss() )[0] );
}

/**
 * Sets a Search Filter to only show posts
 *
 * @param $query
 *
 * @return mixed
 */
function fhgnewsonline_search_filter( $query ) {
	if ( $query->is_search ) {
		$query->set( 'post_type', 'post' );
	}

	return $query;
}

add_filter( 'pre_get_posts', 'fhgnewsonline_search_filter' );


function the_slug_exists( $post_name ) {
	global $wpdb;
	if ( $wpdb->get_row( "SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "' AND post_type ‐‐ 'nav_menu_item'", 'ARRAY_A' ) ) {
		return true;
	} else {
		return false;
	}
}

function create_page_if_not_exists( $slug, $title ) {
	$blog_page = array(
		'post_type'    => 'page',
		'post_title'   => $title,
		'post_content' => '',
		'post_status'  => 'publish',
		'post_author'  => 1,
		'post_name'    => $slug
	);
	if ( ! isset( get_page_by_title( $title )->ID ) && ! the_slug_exists( $title ) ) {
		return wp_insert_post( $blog_page );
	}
	return false;
}