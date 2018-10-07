<?php

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
    setcookie('snackbar', json_encode($snackbar), 0, '/');
}

function resetSnackbar() {
	unset($_COOKIE['snackbar']);
	setcookie('snackbar', '', time() - 3600, '/');
}

if ($_POST['method'] === 'reset') {
	resetSnackbar();
	echo "SUCCESS";
}