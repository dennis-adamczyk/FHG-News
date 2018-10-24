<?php
/**
 * @package fhgnewsonline
 * -- Poll System
 */

/*
 * ===============================
 *      DATABASE
 * ===============================
 */

const POLL_DB_KEY = 'fhgnewsonline_poll_';

/**
 * Adds a poll to a post
 *
 * @param int $post_id
 * @param int|null $poll_id null for auto increment
 * @param bool $multi
 *
 * @return false|int Post Meta ID on success, false on failure
 */
function add_poll( $post_id, $poll_id, $multi = false ) {
	$prev_value = get_polls( $post_id );
	if ( $poll_id === null ) {
		$poll_id = empty( $prev_value ) ? 0 : (int) $prev_value[ count( $prev_value ) - 1 ]['ID'] + 1;
	}
	$value = array(
		'ID'       => $poll_id,
		'voted'    => array(), // IP => Answer Num
		'results'  => array(), // Answer Num => Count
		'settings' => array(
			'multi' => $multi
		)
	);

	return add_post_meta( $post_id, POLL_DB_KEY . $poll_id, $value, true );
}

/**
 * Gets all posts from a post
 *
 * @param $post_id
 *
 * @return array
 */
function get_polls( $post_id ) {
	return array_filter( get_post_meta( $post_id ), function ( $k ) {
		return substr( $k, 0, strlen( POLL_DB_KEY ) ) === POLL_DB_KEY;
	}, ARRAY_FILTER_USE_KEY );
}

/**
 * Gets a specific poll from a post
 *
 * @param int $post_id
 * @param int $poll_id
 *
 * @return array
 */
function get_poll( $post_id, $poll_id ) {
	return get_post_meta( $post_id, POLL_DB_KEY . $poll_id, true );
}

/**
 * Updates or adds a poll to/from a post
 *
 * @param int $post_id
 * @param int $poll_id
 * @param array $value
 *
 * @return array [0] Post Meta ID on success, false on failure [1] Poll ID (will be generated if added as new poll)
 */
function update_poll( $post_id, $poll_id, $value ) {
	$prev_value = get_poll( $post_id, $poll_id );
	if ( $poll_id === null ) {
		$poll_id = empty( $prev_value ) ? 0 : (int) ( intval( end( get_polls( $post_id ) )['ID'] ) + 1 );
	}
	if ( empty( $prev_value ) ) {
		$prev_value = array(
			'ID'       => $poll_id,
			'voted'    => array(), // IP => Answer Num
			'results'  => array(), // Answer Num => Count
			'settings' => array(
				'multi' => false
			)
		);
	}
	$value = array_merge( $prev_value, $value );

	return array( update_post_meta( $post_id, POLL_DB_KEY . $poll_id, $value ), $poll_id );
}

/**
 * Resets a poll by deleting post meta from database
 *
 * @param int $post_id
 * @param int $poll_id
 *
 * @return bool success
 */
function reset_poll( $post_id, $poll_id ) {
	return delete_post_meta($post_id, POLL_DB_KEY . $poll_id);
}

/*
 * ===============================
 *      HELPER
 * ===============================
 */

/**
 * Gets the IP address of the user
 *
 * @return null|string null on failure, IP address on success
 */
function get_user_ip() {
	$ipaddress = null;
	if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	} else if ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else if ( isset( $_SERVER['HTTP_X_FORWARDED'] ) ) {
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	} else if ( isset( $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] ) ) {
		$ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
	} else if ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) ) {
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	} else if ( isset( $_SERVER['HTTP_FORWARDED'] ) ) {
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	} else if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	}

	return $ipaddress;
}

/*
 * ===============================
 *      AJAX
 * ===============================
 */

function fhgnewsonline_ajax_update_poll_vote() {
	$post_id = (int) $_POST["post_id"];
	$poll_id = (int) $_POST["poll_id"];
	$answer  = $_POST["answer"];
	$ip      = get_user_ip();
	$poll    = get_poll( $post_id, $poll_id );
	$voted   = $poll['voted'];
	$results = $poll['results'];
	$multi   = $poll['settings']['multi'];

	if ( (int) $answer === - 1 ) {
		if ( $multi ) {
			$new_voted = array_filter( $voted, function ( $k ) use ( $ip ) {
				return $k !== $ip;
			}, ARRAY_FILTER_USE_KEY );

			$new_results = $results;
			foreach ( $voted[ $ip ] as $voted_answer ) {
				$new_results[ $voted_answer ] = empty( $results[ $voted_answer ] ) ? 0 : ( (int) $results[ $voted_answer ] - 1 );
			}

			echo( intval( update_poll( $post_id, $poll_id, array(
				'voted'   => $new_voted,
				'results' => $new_results,
			) )[0] ) === 1 ? 'S' : 'F' );
			$votes = number_format( empty( $new_voted ) ? 0 : count( $new_voted ), 0, ',', '.' );
			echo( $votes === 1 ? $votes . ' Stimme' : $votes . ' Stimmen' );
		} else {
			$new_voted                    = array_filter( $voted, function ( $k ) use ( $ip ) {
				return $k !== $ip;
			}, ARRAY_FILTER_USE_KEY );
			$new_results                  = $results;
			$voted_answer                 = $voted[ $ip ];
			$new_results[ $voted_answer ] = empty( $results[ $voted_answer ] ) ? 0 : ( (int) $results[ $voted_answer ] - 1 );

			echo( intval( update_poll( $post_id, $poll_id, array(
				'voted'   => $new_voted,
				'results' => $new_results,
			) )[0] ) === 1 ? 'S' : 'F' );
			$votes = number_format( empty( $new_voted ) ? 0 : count( $new_voted ), 0, ',', '.' );
			echo( $votes === 1 ? $votes . ' Stimme' : $votes . ' Stimmen' );
		}
	} else {
		if ( is_array( $answer ) ) {
			if ( $multi !== true ) {
				echo 'F';
				die();
			}
			$new_voted        = $voted;
			$new_voted[ $ip ] = $answer;

			$new_results = $results;
			foreach ( $answer as $a ) {
				$new_results[ $a ] = empty( $results[ $a ] ) ? 1 : ( (int) $results[ $a ] + 1 );
			}
			if ( count( $voted[ $ip ] ) > 0 ) {
				foreach ( $voted[ $ip ] as $voted_answer ) {
					$new_results[ $voted_answer ] = empty( $new_results[ $voted_answer ] ) ? ( empty( $results[ $voted_answer ] ) ? 0 : ( (int) $results[ $voted_answer ] - 1 ) ) : ( (int) $new_results[ $voted_answer ] - 1 );
				}
			}

			echo( intval( update_poll( $post_id, $poll_id, array(
				'voted'   => $new_voted,
				'results' => $new_results,
			) )[0] ) === 1 ? 'S' : 'F' );
			$votes = number_format( empty( $new_voted ) ? 0 : count( $new_voted ), 0, ',', '.' );
			echo( $votes === 1 ? $votes . ' Stimme' : $votes . ' Stimmen' );
			echo '|';
			echo json_encode( $new_results );
			echo '|';
			echo( empty( $new_voted ) ? 0 : count( $new_voted ) );
		} else {
			$new_voted = array(
				$ip => $answer
			);
			$new_voted = array_merge( $voted, $new_voted );

			$new_results            = $results;
			$new_results[ $answer ] = empty( $results[ $answer ] ) ? 1 : ( (int) $results[ $answer ] + 1 );

			if ( count( $voted[ $ip ] ) > 0 ) {
				$voted_answer                 = $voted[ $ip ];
				$new_results[ $voted_answer ] = empty( $new_results[ $voted_answer ] ) ? ( empty( $results[ $voted_answer ] ) ? 0 : ( (int) $results[ $voted_answer ] - 1 ) ) : ( (int) $new_results[ $voted_answer ] - 1 );
			}
			echo( intval( update_poll( $post_id, $poll_id, array(
				'voted'   => $new_voted,
				'results' => $new_results,
			) )[0] ) === 1 ? 'S' : 'F' );
			$votes = number_format( empty( $new_voted ) ? 0 : count( $new_voted ), 0, ',', '.' );
			echo( $votes === 1 ? $votes . ' Stimme' : $votes . ' Stimmen' );
			echo '|';
			echo json_encode( $new_results );
			echo '|';
			echo( empty( $new_voted ) ? 0 : count( $new_voted ) );
		}
	}

	die();
}

add_action( 'wp_ajax_nopriv_update_poll_vote', 'fhgnewsonline_ajax_update_poll_vote' );
add_action( 'wp_ajax_update_poll_vote', 'fhgnewsonline_ajax_update_poll_vote' );


function fhgnewsonline_ajax_get_poll_results() {
	$post_id = (int) $_POST["post_id"];
	$poll_id = (int) $_POST["poll_id"];
	$ip      = get_user_ip();
	$poll    = get_poll( $post_id, $poll_id );
	$voted   = $poll['voted'];
	$results = $poll['results'];

	if ( count( $voted[ $ip ] ) > 0 ) {
		echo 'S';
		echo is_array( $voted[ $ip ] ) ? json_encode( $voted[ $ip ] ) : $voted[ $ip ];
		echo '|';
		echo json_encode( $results );
		echo '|';
		echo( empty( $voted ) ? 0 : count( $voted ) );
	} else {
		echo 'F';
	}

	die();
}

add_action( 'wp_ajax_nopriv_get_poll_results', 'fhgnewsonline_ajax_get_poll_results' );
add_action( 'wp_ajax_get_poll_results', 'fhgnewsonline_ajax_get_poll_results' );

/*
 * ===============================
 *      SHORTCODE
 * ===============================
 */

function fhgnewsonline_poll_shortcode( $atts, $content, $tag ) {
	global $post;
	$multi = empty( $atts ) ? false : in_array( 'multi', $atts );
	$atts  = shortcode_atts( array(
		'multi' => $multi,
		'id'    => null
	), $atts );

	$atts['id'] = update_poll( $post->ID, (int) $atts['id'], array( 'settings' => array( 'multi' => $atts['multi'] ) ) )[1];

	return '<poll data-id="' . $atts['id'] . '" ' . ( $atts['multi'] ? 'multi' : '' ) . '>' . str_replace( array(
			'<br/>',
			'<br>',
			'<br />'
		), '', do_shortcode(
				str_replace( '[frage]', '[frage poll_id="' . $atts['id'] . '"]',
					$atts['multi'] ?
						str_replace( '[antwort]', '[antwort group="' . $atts['id'] . '" multi]', $content ) :
						str_replace( '[antwort]', '[antwort group="' . $atts['id'] . '"]', $content )
				)
			)
		) . '</poll>';
}

add_shortcode( 'umfrage', 'fhgnewsonline_poll_shortcode' );

function fhgnewsonline_poll_question_shortcode( $atts, $content, $tag ) {
	global $post;
	$atts  = shortcode_atts( array(
		'poll_id' => 0
	), $atts );
	$votes = number_format( empty( get_poll( $post->ID, (int) $atts['poll_id'] )['voted'] ) ? 0 : count( get_poll( $post->ID, (int) $atts['poll_id'] )['voted'] ), 0, ',', '.' );

	return '<p class="poll_question">' . $content . '</p><p class="poll_votes">' . ( $votes === '1' ? ( $votes . ' Stimme' ) : ( $votes . ' Stimmen' ) ) . '</p>';
}

add_shortcode( 'frage', 'fhgnewsonline_poll_question_shortcode' );

function fhgnewsonline_poll_answer_shortcode( $atts, $content, $tag ) {
	$multi        = in_array( 'multi', $atts );
	$atts         = shortcode_atts( array(
		'multi' => $multi,
		'group' => uniqid()
	), $atts );
	$nice_content = preg_replace( "/[^A-Za-z-]/", '', str_replace( ' ', '-', strtolower( $content ) ) ) . '-' . uniqid();

	return '<p class="poll_answer">' . ( $atts['multi'] ? '<input type="checkbox" name="poll-' . $atts['group'] . '" id="' . $nice_content . '">' : '<input type="radio" name="poll-' . $atts['group'] . '" id="' . $nice_content . '">' ) . '<label for="' . $nice_content . '"><span>' . str_replace( '<br>', '', $content ) . '</span></label></p>';
}

add_shortcode( 'antwort', 'fhgnewsonline_poll_answer_shortcode' );

/*
[umfrage id=1 multi="nein"]
  [frage]Was ist dein Lieblingseis?[/frage]
  [antwort]Vanille[/antwort]
  [antwort]Erdber[/antwort]
  [antwort]Schoko[/antwort]
  [antwort]Sonstiges (Kommentar)[/antwort]
  [antwort]Ich mag kein Eis[/antwort]
[/umfrage]
*/