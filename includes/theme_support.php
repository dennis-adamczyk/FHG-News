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
		'ajax_url'               => admin_url( 'admin-ajax.php' ),
		'login_url'              => wp_login_url(),
		'snackbar_post'          => stripslashes( $_COOKIE["snackbar"] ),
		'max_num_pages'          => $GLOBALS["wp_query"]->max_num_pages,
		'paged'                  => get_query_var( 'paged' ) == 0 ? 1 : get_query_var( 'paged' ),
		'user_id'                => get_current_user_id(),
		'user_email'             => wp_get_current_user()->user_email,
		'display_name'           => wp_get_current_user()->display_name,
	) );

	if ( is_home() && ! get_query_var( 'fhgnewsonline_page_id' ) ) {
		wp_enqueue_style( 'blog', get_template_directory_uri() . '/css/blog.css' );
		wp_enqueue_script( 'blog', get_template_directory_uri() . '/js/blog.js' );
	}
	if ( is_single() ) {
		wp_enqueue_style( 'single', get_template_directory_uri() . '/css/single.css' );
		wp_enqueue_style( 'gutenberg-frontend', get_template_directory_uri() . '/css/gutenberg-frontend.css' );
		wp_enqueue_script( 'single', get_template_directory_uri() . '/js/single.js' );
		wp_localize_script( 'single', 'php_vars', array(
			'login_url'        => wp_login_url(),
			'registration_url' => wp_registration_url(),
			'post_id'          => get_the_ID(),
			'post'             => get_post(),
		) );
	}
	if ( is_page() ) {
		wp_enqueue_style( 'page', get_template_directory_uri() . '/css/page.css' );
		if ( is_page( 'ueber-uns' ) ) {
			wp_enqueue_style( 'page-ueber-uns', get_template_directory_uri() . '/css/page-ueber-uns.css' );
		}
		if ( is_page( 'dein-beitrag' ) ) {
			wp_enqueue_style( 'page-dein-beitrag', get_theme_file_uri( '/css/page-dein-beitrag.css' ) );
			wp_enqueue_script( 'page-dein-beitrag', get_theme_file_uri( '/js/page-dein-beitrag.js' ) );
		}
		if ( is_page( 'kontakt' ) ) {
			wp_enqueue_style( 'page-kontakt', get_theme_file_uri( '/css/page-kontakt.css' ) );
		}
	}
	if ( is_search() ) {
		wp_enqueue_style( 'search', get_template_directory_uri() . '/css/search.css' );
		wp_enqueue_script( 'search', get_template_directory_uri() . '/js/search.js' );
		wp_localize_script( 'search', 'php_vars', array(
			's' => get_query_var( 's' ),
		) );
	}
	if ( is_404() ) {
		wp_enqueue_style( 'error404', get_template_directory_uri() . '/css/error404.css' );
	}
	if ( is_category() ) {
		wp_enqueue_style( 'category', get_template_directory_uri() . '/css/category.css' );
		wp_enqueue_script( 'category', get_template_directory_uri() . '/js/category.js' );
		wp_localize_script( 'category', 'php_vars', array(
			'cat_id' => get_the_category()[0]->cat_ID,
		) );
	}
	if ( is_archive() && ! is_category() && ! is_author() ) {
		wp_enqueue_style( 'archive', get_template_directory_uri() . '/css/archive.css' );
		wp_enqueue_script( 'archive', get_template_directory_uri() . '/js/archive.js' );
		wp_localize_script( 'archive', 'php_vars', array(
			'year'  => get_query_var( 'year' ),
			'month' => get_query_var( 'monthnum' ),
			'day'   => get_query_var( 'day' ),
		) );
	}
	if ( is_author() ) {
		wp_enqueue_style( 'author', get_template_directory_uri() . '/css/author.css' );
		wp_enqueue_script( 'author', get_template_directory_uri() . '/js/author.js' );
		wp_localize_script( 'author', 'php_vars', array(
			'author' => get_query_var( 'author' ),
		) );
	}
	if ( get_query_var( 'fhgnewsonline_page_id' ) == 1 ) {
		wp_enqueue_style( 'edit_profiles', get_template_directory_uri() . '/css/edit_profile.css' );
		wp_enqueue_script( 'edit_profiles', get_template_directory_uri() . '/js/edit_profile.js' );
		wp_enqueue_style( 'croppie', get_template_directory_uri() . '/vendor/css/croppie.css' );
		wp_enqueue_script( 'croppie', get_template_directory_uri() . '/vendor/js/croppie.min.js' );
	}
	if ( get_query_var( 'fhgnewsonline_page_id' ) == 3 ) {
		wp_dequeue_style( 'login' );
		wp_enqueue_style( 'login_page', get_template_directory_uri() . '/css/login.css' );
		wp_enqueue_script( 'login_page', get_template_directory_uri() . '/js/login.js' );
	}
	if ( get_query_var( 'fhgnewsonline_page_id' ) == 4 ) {
		wp_dequeue_style( 'login' );
		wp_enqueue_style( 'register_page', get_template_directory_uri() . '/css/register.css' );
		wp_enqueue_script( 'register_page', get_template_directory_uri() . '/js/register.js' );
	}
	if ( get_query_var( 'fhgnewsonline_page_id' ) == 5 ) {
		wp_dequeue_style( 'login' );
		wp_enqueue_style( 'reset_password_page', get_template_directory_uri() . '/css/reset_password.css' );
		wp_enqueue_script( 'reset_password_page', get_template_directory_uri() . '/js/reset_password.js' );
	}
	if ( get_query_var( 'fhgnewsonline_page_id' ) == 6 ) {
		wp_enqueue_style( 'settings', get_template_directory_uri() . '/css/settings.css' );
		wp_enqueue_script( 'settings', get_template_directory_uri() . '/js/settings.js' );
	}

	show_admin_bar( false );
	add_filter( 'show_admin_bar', '__return_false' );
	if ( is_user_logged_in() ) {
		update_user_meta( get_current_user_id(), 'show_admin_bar_front', 0 );
	}

//	add_action('pwp_serviceworker', function() {
//	  echo "workbox.routing.registerRoute(/login(.*)|user(.*)/, workbox.strategies.networkOnly());";
//  });
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

	// MAILS
	if ( is_array( get_option( 'haet_mail_theme_options' ) ) ) {
		update_option( 'haet_mail_theme_options', array_merge( get_option( 'haet_mail_theme_options' ), FHGNEWSONLINE_MAIL_STYLES ) );
	}


	// GUTENBERG
	add_theme_support( 'editor-color-palette', MATERIAL_DESIGN_COLORS );

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
	create_page_if_not_exists( 'kontakt', 'Kontakt' );
	create_page_if_not_exists( 'impressum', 'Impressum' );
	create_page_if_not_exists( 'datenschutz', 'Datenschutz' );
	create_page_if_not_exists( 'offline', 'Offline' );

	include get_template_directory() . "/includes/appbar.php";
	include get_template_directory() . "/includes/likeSystem.php";
	include get_template_directory() . "/includes/comment_format.php";
	include get_template_directory() . "/includes/user_meta.php";
	include get_template_directory() . "/includes/profile_picture_system.php";
	include get_template_directory() . "/includes/post_views.php";
	include get_template_directory() . "/includes/user_settings.php";
	include get_template_directory() . "/includes/poll_system.php";
	include get_template_directory() . "/includes/mail_filter.php";
	include get_template_directory() . "/includes/admin_menu.php";

	flush_rewrite_rules( true );
	profile_picture_init();

	/* ===== GUTENBERG ===== */

	wp_enqueue_script( 'gutenberg_register_poll_block', get_theme_file_uri( '/js/gutenberg_register_poll_block.js' ), array(
		'wp-blocks',
		'wp-element',
		'wp-editor',
		'wp-components',
	) );
	wp_localize_script( 'gutenberg_register_poll_block', 'php_vars', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'post_id'  => get_the_ID(),
	) );

	if ( function_exists( 'register_block_type' ) ) {
		register_block_type( 'fhgnewsonline/poll', array(
			'editor_script'   => 'gutenberg_register_poll_block',
			'render_callback' => 'fhgnewsonline_get_poll_shortcode'
		) );
	}
}

add_action( 'init', 'fhgnewsonline_theme_setup' );

function fhgnewsonline_add_gutenberg_assets() {
	wp_enqueue_style( 'gutenberg-backend', get_theme_file_uri( '/css/gutenberg-backend.css' ), false );
}

add_action( 'enqueue_block_editor_assets', 'fhgnewsonline_add_gutenberg_assets' );


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
 * Echos previous page content for a specific template type
 *
 * @param string|null $type
 * @param array $details
 */
function fhgnewsonline_printPaged( $type = null, $details = array() ) {
	global $count;
	if ( is_paged() ) {
		for ( $i = 1; $i < get_query_var( 'paged' ); $i ++ ) {
			switch ( $type ) {
				case "category":
					$args = array(
						'post_type'   => 'post',
						'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
							'publish',
							'private'
						) : 'publish' ),
						'paged'       => $i,
						'cat'         => $details["cat_id"],
					);
					break;

				case "archive":
					$args = array(
						'post_type'   => 'post',
						'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
							'publish',
							'private'
						) : 'publish' ),
						'paged'       => $i,
						'year'        => $details["year"],
						'monthnum'    => $details["monthnum"],
						'day'         => $details["day"],
					);
					break;

				case "search":
					$args = array(
						'post_type'   => 'post',
						'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
							'publish',
							'private'
						) : 'publish' ),
						'paged'       => $i,
						's'           => $details["s"],
					);
					break;

				case "author":
					$args = array(
						'post_type'   => 'post',
						'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
							'publish',
							'private'
						) : 'publish' ),
						'paged'       => $i,
						'author'      => $details["author"],
					);
					break;

				default:
					$args = array(
						'post_type'   => 'post',
						'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
							'publish',
							'private'
						) : 'publish' ),
						'paged'       => $i,
					);
					break;
			}
			$query = new WP_Query( $args );

			if ( $query->have_posts() ):
				while ( $query->have_posts() ):
					$query->the_post();

					get_template_part( 'formats/post/content', get_post_format() );

					if ( $count % 4 == 0 && $count !== 0 ): ?>

                      <!--TODO Werbung-->

					<?php
					endif;
					$count ++;
				endwhile;
			endif;
			wp_reset_postdata();
		}
	}
}

/**
 * Prints recommended Posts
 *
 * @param $post
 * @param int $paged
 */
function fhgnewsonline_printRecommendedPosts( $post, $paged = 1 ) {
	if ( ! $post ) {
		global $post;
	}
	$tags = wp_get_post_tags( $post->ID );

	if ( $tags ) {
		$tag_ids = array();
		foreach ( $tags as $individual_tag ) {
			$tag_ids[] = $individual_tag->term_id;
		}
		$related_query = new WP_Query( array(
			'tag__in'          => $tag_ids,
			'post__not_in'     => array( $post->ID ),
			'posts_per_page'   => 3,
			'caller_get_posts' => 1,
			'paged'            => $paged,
		) );

	} else {
		$categories = wp_get_post_categories( $post->ID );

		if ( $categories ) {
			$cat_ids       = $categories;
			$related_query = new WP_Query( array(
				'category__in'     => $cat_ids,
				'post__not_in'     => array( $post->ID ),
				'posts_per_page'   => 3,
				'caller_get_posts' => 1,
				'paged'            => $paged,
			) );
		}
	}
	if ( isset( $related_query ) ) {
		if ( $related_query->have_posts() ) {
			while ( $related_query->have_posts() ) {
				$related_query->the_post();
				$category_color = function_exists( 'rl_color' ) ? rl_color( get_the_category()[0]->cat_ID ) : '';
				$featured_image = false;

				if ( has_post_thumbnail() ) {
					$featured_image = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
				} else if ( $img = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches ) ) {
					$featured_image = $matches[1][0];
				} ?>
              <article <?php post_class( 'recommended__post' ); ?>
                  onclick="window.location = '<?php echo get_the_permalink(); ?>'">
                <div class="post__image" style="background-image: url('<?php echo $featured_image; ?>')">
					<?php if ( ! $featured_image ): ?>
                      <div class="post__image__error">
                        <i class="material-icons">error</i>
                        <p>Kein Bild gefunden!</p>
                      </div>
					<?php endif; ?>
                </div>
                <h4 class="post__title"><?php the_title(); ?></h4>
                <p class="post__subtitle">
                    <span class="post__subtitle__category">
                    <?php if ( empty( get_the_category() ) ): echo "Unkategorisiert";
                    else:
	                    if ( get_the_category()[0]->parent !== 0 ):
		                    echo '<span class="post__subtitle__category__parent" style="color: ' . rl_color( get_category( get_the_category()[0]->parent )->cat_ID ) . ';" onclick="window.location = \'' . get_category_link( get_category( get_the_category()[0]->parent )->cat_ID ) . '\'">' .
		                         get_category( get_the_category()[0]->parent )->name .
		                         '</span>' .
		                         '<i class="material-icons">chevron_right</i>' .
		                         '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( get_the_category()[0]->cat_ID ) . '\'">' .
		                         get_the_category()[0]->name .
		                         '</span>';
	                    else:
		                    echo '<span class="post__subtitle__category__sub" style="color: ' . $category_color . ';" onclick="window.location = \'' . get_category_link( get_the_category()[0]->cat_ID ) . '\'">' .
		                         get_the_category()[0]->name .
		                         '</span>';
	                    endif; endif; ?>
                  </span> &bull; vor <?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ); ?>
                </p>
                <div class="post__foot">
                  <div
                      class="post__foot__like<?php if ( is_user_logged_in() && has_liked( get_the_ID(), get_current_user_id() ) ) {
						  echo " active";
					  } ?>">
                    <i class="material-icons">favorite</i>
                    <p class="post__foot__like__count"><?php echo get_like_amount( get_the_ID() ); ?></p>
                  </div>
                  <div class="post__foot__comments">
                    <i class="material-icons">insert_comment</i>
                    <p class="post__foot__comments__count"><?php echo get_comments_number() ?: ''; ?></p>
                  </div>
                  <div class="post__foot__share"
                       onclick="event.stopPropagation(); showShareDialog('<?php echo get_permalink(); ?>', '<?php echo get_the_title(); ?>');">
                    <i class="material-icons">share</i>
                  </div>
                </div>
              </article>

				<?php
			}
		} else {
			?>
          <div class="recommended__error">
            <p>Keine Artikel vorhanden.</p>
          </div>
			<?php
		}
	} else {
		?>
      <div class="recommended__error">
        <p>Keine Artikel vorhanden.</p>
      </div>
		<?php
	}
	wp_reset_query();
}


/**
 * Retrives the password
 *
 * @param string $user_login Username or email
 *
 * @return bool|WP_Error
 */
function fhgnewsonline_retrieve_password( $user_login ) {
	$errors = new WP_Error();

	if ( empty( $user_login ) || ! is_string( $user_login ) ) {
		$errors->add( 'empty_username', __( '<strong>ERROR</strong>: Enter a username or email address.' ) );
	} elseif ( strpos( $user_login, '@' ) ) {
		$user_data = get_user_by( 'email', trim( wp_unslash( $user_login ) ) );
		if ( empty( $user_data ) ) {
			$errors->add( 'invalid_email', __( '<strong>ERROR</strong>: There is no user registered with that email address.' ) );
		}
	} else {
		$login     = trim( $user_login );
		$user_data = get_user_by( 'login', $login );
	}

	do_action( 'lostpassword_post', $errors );

	if ( $errors->get_error_code() ) {
		return $errors;
	}

	if ( ! $user_data ) {
		$errors->add( 'invalidcombo', __( '<strong>ERROR</strong>: Invalid username or email.' ) );

		return $errors;
	}

	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;
	$key        = get_password_reset_key( $user_data );

	if ( is_wp_error( $key ) ) {
		return $key;
	}

	$site_name = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

	$message = '<h1>Passwort zurücksetzen</h1>';
	$message .= '<p>Du hast das Zurücksetzen deines Passworts beantragt. Klicke auf den untern stehenden Link um dein Passwort für dein Konto auf <a href="' . get_home_url() . '">FHG News</a> zu ändern. Zukünftig wirst du dich mit deinem Benutzernamen <b>' . $user_login . '</b> und deinem neuen Passwort anmelden können.</p>';
	$message .= '<p>Solltest du das Zurücksetzen deines Passworts nicht beantragt haben oder du hast dich verklickt, kannst du diese E-Mail einfach ignorieren und dich weiterhin mit deinem alten Passwort anmelden.</p>';
	$message .= '<p>Klicke auf diesen Link um dein Passwort zu ändern:</p>';
	$message .= '<a class="button" href="' . network_site_url( "/login/reset-password/?change&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . '"><span>Passwort ändern</span></a>';

	$title = 'Password zurücksetzen';

	$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

	$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );

	if ( $message && ! wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
		wp_die( __( 'The email could not be sent.' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.' ) );
	}

	return true;
}

function get_reset_password_url( $user_id_or_login = null ) {
	if ( $user_id_or_login === null ) {
		$user_id_or_login = get_current_user_id();
	}
	if ( is_numeric( $user_id_or_login ) ) {
		$user_login = get_user_by( 'ID', $user_id_or_login )->user_login;
	} else {
		$user_login = $user_id_or_login;
	}

	return wp_lostpassword_url() . '?change&key=' . get_password_reset_key( wp_get_current_user() ) . '&login=' . rawurlencode( $user_login );
}

/**
 * @param string $string
 * @param int $limit
 * @param string $more
 *
 * @param null $line_limit
 *
 * @return null|string|string[]
 */
function trim_words( $string, $limit, $more, $line_limit = null ) {
	$new_string = preg_replace( '/((\w+\W*){0,' . ( $limit - 1 ) . '}(\w*))(.*)/', '${1}', $string );
	if ( $line_limit !== null ) {
		$new_string = implode( '<br>', array_slice( explode( '<br>', $new_string ), 0, $line_limit ) );
	}
	if ( $new_string !== $string ) {
		$new_string = trim( $new_string ) . $more;
	}

	return $new_string;
}

define( 'MATERIAL_DESIGN_COLORS', array(
	array(
		'name'  => esc_html( 'Schwarz' ),
		'slug'  => 'black',
		'color' => '#000000',
	),
	array(
		'name'  => esc_html( 'Weiß' ),
		'slug'  => 'white',
		'color' => '#ffffff',
	),
	array(
		'name'  => esc_html( 'Rot' ),
		'slug'  => 'red',
		'color' => '#F44336',
	),
	array(
		'name'  => esc_html( 'Pink' ),
		'slug'  => 'pink',
		'color' => '#E91E63',
	),
	array(
		'name'  => esc_html( 'Lila' ),
		'slug'  => 'purple',
		'color' => '#9C27B0',
	),
	array(
		'name'  => esc_html( 'Dunkellila' ),
		'slug'  => 'deep-purple',
		'color' => '#673AB7',
	),
	array(
		'name'  => esc_html( 'Indigo' ),
		'slug'  => 'indigo',
		'color' => '#3F51B5',
	),
	array(
		'name'  => esc_html( 'Blau' ),
		'slug'  => 'secondary',
		'color' => '#2196F3',
	),
	array(
		'name'  => esc_html( 'Hellblau' ),
		'slug'  => 'light-blue',
		'color' => '#03A9F4',
	),
	array(
		'name'  => esc_html( 'Cyan' ),
		'slug'  => 'cyan',
		'color' => '#00BCD4',
	),
	array(
		'name'  => esc_html( 'Teal' ),
		'slug'  => 'teal',
		'color' => '#009688',
	),
	array(
		'name'  => esc_html( 'Grün' ),
		'slug'  => 'green',
		'color' => '#4CAF50',
	),
	array(
		'name'  => esc_html( 'Hellgrün' ),
		'slug'  => 'light-green',
		'color' => '#8BC34A',
	),
	array(
		'name'  => esc_html( 'Limette' ),
		'slug'  => 'lime',
		'color' => '#CDDC39',
	),
	array(
		'name'  => esc_html( 'Gelb' ),
		'slug'  => 'yellow',
		'color' => '#FFEB3B',
	),
	array(
		'name'  => esc_html( 'Amber' ),
		'slug'  => 'amber',
		'color' => '#FFC107',
	),
	array(
		'name'  => esc_html( 'Orange' ),
		'slug'  => 'orange',
		'color' => '#FF9800',
	),
	array(
		'name'  => esc_html( 'Dunkelorange' ),
		'slug'  => 'deep-orange',
		'color' => '#FF5722',
	),
	array(
		'name'  => esc_html( 'Braun' ),
		'slug'  => 'brown',
		'color' => '#795548',
	),
	array(
		'name'  => esc_html( 'Grau' ),
		'slug'  => 'grey',
		'color' => '#9E9E9E',
	),
	array(
		'name'  => esc_html( 'Blau-Grau' ),
		'slug'  => 'blue-grey',
		'color' => '#607D8B',
	),
) );

define( 'FHGNEWSONLINE_MAIL_STYLES', array(
	'background'          => '#fafafa',
	'contentbackground'   => '#FFFFFF',
	'headertext'          => 'FHG News',
	'headerfont'          => 'Helvetica, Arial, sans-serif',
	'headeralign'         => 'left',
	'headerfontsize'      => '40',
	'headerbold'          => '0',
	'headeritalic'        => '0',
	'headerbackground'    => '#1976d2',
	'headercolor'         => '#ffffff',
	'headerpaddingtop'    => '50',
	'headerpaddingright'  => '24',
	'headerpaddingbottom' => '12',
	'headerpaddingleft'   => '24',
	'headerimg'           => get_theme_file_uri( '/img/mails/fhgnews_white.png' ),
	'headerimg_width'     => '187',
	'headerimg_height'    => '30',
	'headlinefont'        => 'Helvetica, Arial, sans-serif',
	'headlinealign'       => 'left',
	'headlinefontsize'    => '24',
	'headlinebold'        => '0',
	'headlineitalic'      => '0',
	'headlinecolor'       => '#000000',
	'subheadlinefont'     => 'Helvetica, Arial, sans-serif',
	'subheadlinealign'    => 'left',
	'subheadlinefontsize' => '20',
	'subheadlinebold'     => '0',
	'subheadlineitalic'   => '0',
	'subheadlinecolor'    => '#242424',
	'textfont'            => 'Helvetica, Arial, sans-serif',
	'textalign'           => 'left',
	'textfontsize'        => '14',
	'textbold'            => '0',
	'textitalic'          => '0',
	'textcolor'           => '#242424',
	'linkcolor'           => '#2196f3',
	'linkbold'            => '0',
	'linkitalic'          => '0',
	'linkunderline'       => 1,
	'footerlink'          => '0',
	'footerbackground'    => '#1976d2',
) );

/*
 * ===============================
 *      INSTALL PLUGINS NOTICE
 * ===============================
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
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
if ( ! is_plugin_active( 'onesignal-free-web-push-notifications/onesignal.php' ) ) {
	function install_onesignal_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'onesignal-free-web-push-notifications' ); ?>">OneSignal</a>
          installieren und aktivieren!
        </p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_onesignal_notice' );
}
if ( ! is_plugin_active( 'progressive-wp/progressive-wordpress.php' ) ) {
	function install_progressive_wp_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'progressive-wp' ); ?>">Progressive WP</a> installieren und
          aktivieren!
        </p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_progressive_wp_notice' );
}
if ( ! is_plugin_active( 'wp-html-mail/wp-html-mail.php' ) ) {
	function install_wp_html_mail_notice() {
		?>
      <div class="notice notice-warning">
        <p>[FHG News] <a href="<?php the_plugin_url( 'wp-html-mail' ); ?>">WP HTML Mail</a> installieren und
          aktivieren!
        </p>
      </div>
		<?php
	}

	add_action( 'admin_notices', 'install_wp_html_mail_notice' );
}


/**
 * Echos the plugin install url
 *
 * @param $plugin_name
 */
function the_plugin_url( $plugin_name ) {
	echo esc_url( network_admin_url( 'plugin-install.php?tab=plugin-information&plugin=' . $plugin_name ) );
}