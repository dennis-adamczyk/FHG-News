<?php
/**
 * @package fhgnewsonline
 * -- Snackbar functions
 */

/**
 * Displays a Snackbar with one line of information text on the page refresh or change
 *
 * @param $message
 *
 * @return bool Success
 */
function addNextSingleLineSnackbar( $message ) {
	$snackbar = $_COOKIE['snackbar'];
	if ( isset( $snackbar ) ) {
		$snackbar = json_decode( $snackbar );
		$snackbar[] = array(
			'type' => 'singleLine',
			'message' => $message
		);
    } else {
		$snackbar = array(
			array(
				'type' => 'singleLine',
				'message' => $message
			),
		);
    }
    return setcookie('snackbar', json_encode($snackbar), 0, '/');
}

/**
 * Resets all requests for displaying Snackbars
 *
 * @return bool Success
 */
function resetSnackbar() {
	unset($_COOKIE['snackbar']);
	return setcookie('snackbar', '', time() - 3600, '/');
}

if ($_POST['method'] === 'reset') {
	resetSnackbar();
	echo "SUCCESS";
}