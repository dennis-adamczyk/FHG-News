<?php
/**
 * @package fhgnewsonline
 * -- Theme Support
 */


/**
 * Embeds styles and scripts
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
		'ajaxurl'                => admin_url( 'admin-ajax.php' ),
		'login_url'              => wp_logout_url(),
		'snackbar_post'          => $_COOKIE["snackbar"],
	) );

	if ( is_home() && ! get_query_var( 'fhgnewsonline_page_id' ) ) {
		wp_enqueue_style( 'blog', get_template_directory_uri() . '/css/blog.css' );
	}
	if ( is_single() ) {
		wp_enqueue_style( 'single', get_template_directory_uri() . '/css/single.css' );
		wp_enqueue_script( 'single', get_template_directory_uri() . '/js/single.js' );
		wp_localize_script( 'single', 'php_vars', array(
			'login_url'        => wp_login_url(),
			'registration_url' => wp_registration_url(),
			'post_id'          => get_the_ID()
		) );
	}
	if ( is_page() ) {
		wp_enqueue_style( 'page', get_template_directory_uri() . '/css/page.css' );
		if ( is_page( 'ueber-uns' ) ) {
			wp_enqueue_style( 'page-ueber-uns', get_template_directory_uri() . '/css/page-ueber-uns.css' );
		}
	}
	if ( is_search() ) {
		wp_enqueue_style( 'search', get_template_directory_uri() . '/css/search.css' );
	}
	if ( is_404() ) {
		wp_enqueue_style( 'error404', get_template_directory_uri() . '/css/error404.css' );
	}
	if ( is_category() ) {
		wp_enqueue_style( 'category', get_template_directory_uri() . '/css/category.css' );
	}
	if ( is_archive() ) {
		wp_enqueue_style( 'archive', get_template_directory_uri() . '/css/archive.css' );
	}
	if ( is_author() ) {
		wp_enqueue_style( 'author', get_template_directory_uri() . '/css/author.css' );
	}
	if ( get_query_var( 'fhgnewsonline_page_id' ) == 1 ) {
		wp_enqueue_style( 'edit_profiles', get_template_directory_uri() . '/css/edit_profile.css' );
		wp_enqueue_script( 'edit_profiles', get_template_directory_uri() . '/js/edit_profile.js' );
	}
}

add_action( 'wp_enqueue_scripts', 'fhgnewsonline_enqueue' );

/**
 * Sets the theme up
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

	create_page_if_not_exists( 'ueber-uns', 'Über Uns' );
	create_page_if_not_exists( 'dein-beitrag', 'Dein Beitrag' );
	create_page_if_not_exists( 'kantakt', 'Kontakt' );
	create_page_if_not_exists( 'impressum', 'Impressum' );
	create_page_if_not_exists( 'datenschutz', 'Datenschutz' );

	include "includes/appbar.php";
	include "includes/likeSystem.php";
	include "includes/comment_format.php";
}

add_action( 'init', 'fhgnewsonline_theme_setup' );

/**
 * Get title of current page
 *
 * @return string page_title
 */
function fhgnewsonline_get_page_title() {
	return ( explode( ' &#8211;', get_wp_title_rss() )[0] == get_bloginfo_rss( 'name' ) || is_single() || is_category() ? 'News' : ( is_404() ? 'Fehler 404' : ( is_author() ? 'Profil' : ( explode( '&#8211;', get_wp_title_rss() )[0] ) ) ) );
}

/**
 * Returns the name of user role
 *
 * @param $user
 *
 * @return string|null
 */
function get_user_role_name( $user ) {
	global $wp_roles;

	return $wp_roles->roles[ $user->roles[0] ]['name'];
}

/**
 * Returns hex color code for user role
 *
 * @param $user
 *
 * @return string|false
 */
function get_user_role_color( $user ) {
	$user_role = $user->roles[0];
	$colors    = [
		'administrator' => '#F44336',
		'editor'        => '#FF9800',
		'author'        => '#009688',
		'contributor'   => '#00BCD4',
		'subscriber'    => '#2196F3',
	];
	foreach ( $colors as $role => $color ) {
		if ( $role === $user_role ) {
			return $color;
		}
	}

	return false;
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


/**
 * Checks if post name slug exists
 *
 * @param $post_name
 *
 * @return bool
 */
function the_slug_exists( $post_name ) {
	global $wpdb;
	if ( $wpdb->get_row( "SELECT post_name FROM wp_posts WHERE post_name = '" . $post_name . "' AND post_type ‐‐ 'nav_menu_item'", 'ARRAY_A' ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Creates a page if this page not already exists
 *
 * @param $slug
 * @param $title
 *
 * @return bool|int|WP_Error
 */
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


/**
 * Echos category color of category with given category name in $_POST['cat']
 */
function get_rl_color() {
	echo function_exists( 'rl_color' ) ? rl_color( get_cat_ID( $_POST['cat'] ) ) : '';
}

add_action( 'wp_ajax_nopriv_get_rl_color', 'get_rl_color' );
add_action( 'wp_ajax_get_rl_color', 'get_rl_color' );



/*
 * ===============================
 *      INSTALL PLUGINS NOTICE
 * ===============================
 */

if ( ! is_plugin_active( 'category-color/rl_category_color.php' ) ) {
	function install_category_color_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'category-color' ); ?>">Category Color</a> installieren und
          aktivieren!</p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_category_color_notice' );
}
if ( ! is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
	function install_gutenberg_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'gutenberg' ); ?>">Gutenberg</a> installieren und aktivieren!</p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_gutenberg_notice' );
}
if ( ! is_plugin_active( 'user-role-editor/user-role-editor.php' ) ) {
	function install_user_role_editor_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'user-role-editor' ); ?>">User Role Editor</a> installieren und
          aktivieren!</p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_user_role_editor_notice' );
}
if ( ! is_plugin_active( 'wp-mail-smtp/wp_mail_smtp.php' ) ) {
	function install_wp_mail_smtp_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'wp-mail-smtp' ); ?>">WP Mail SMTP</a> installieren und aktivieren!
        </p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_wp_mail_smtp_notice' );
}


/**
 * Echos the plugin install url
 *
 * @param $plugin_name
 */
function the_plugin_url( $plugin_name ) {
	echo esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_name ) );
}