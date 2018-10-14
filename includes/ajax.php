<?php
/**
 * @package fhgnewsonline
 * -- Ajax Functions
 */

/**
 * Echos category color of category with given category name in $_POST['cat']
 */
function get_rl_color() {
	echo function_exists( 'rl_color' ) ? rl_color( get_cat_ID( $_POST['cat'] ) ) : '';
}

add_action( 'wp_ajax_nopriv_get_rl_color', 'get_rl_color' );
add_action( 'wp_ajax_get_rl_color', 'get_rl_color' );

function fhgnewsonline_infinite_scroll_content() {
	global $count;
	$type    = $_POST["type"];
	$details = $_POST["details"];
	$paged   = $_POST["page"] + 1;
	switch ( $type ) {
		case "category":
			$args = array(
				'post_type'   => 'post',
				'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
					'publish',
					'private'
				) : 'publish' ),
				'paged'       => $paged,
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
				'paged'       => $paged,
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
				'paged'       => $paged,
				's'           => $details["s"],
			);
			break;

		case "recommended":
			fhgnewsonline_printRecommendedPosts( get_post( $details["post"]["ID"] ), $paged );
			die();
			break;

		default:
			$args = array(
				'post_type'   => 'post',
				'post_status' => ( current_user_can( 'read_private_pages' ) ? array(
					'publish',
					'private'
				) : 'publish' ),
				'paged'       => $paged,
			);
			break;
	}

	$query = new WP_Query( $args );

	$count = ( ( $paged - 1 ) * 5 );
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

	die();
}

add_action( 'wp_ajax_nopriv_fhgnewsonline_infinite_scroll_content', 'fhgnewsonline_infinite_scroll_content' );
add_action( 'wp_ajax_fhgnewsonline_infinite_scroll_content', 'fhgnewsonline_infinite_scroll_content' );