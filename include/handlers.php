<?php

function showErrorPage( $code ) {
	ob_clean();
	http_response_code( $code );
	$_SERVER[ 'REDIRECT_STATUS' ] = $code;
	include( '/opt/httpd/htdocs/public/error.php' );
	exit();
}

function errorHandler( $code, $message, $path, $line, $fatal = false ) {
	if ( $fatal !== true ) error_log( 'PHP Runtime error: ' . $code . ' - ' . $message . ' in ' . $path . ' on line ' . $line );
	showErrorPage( 500 );
}

function shutdownHandler() {
	$error = error_get_last();

	if ( is_array( $error ) ) {
		$code = $error[ 'type' ] ?? 0;
		$message = $error[ 'message' ] ?? '';
		$path = $error[ 'file' ] ?? '';
		$line = $error[ 'line' ] ?? null;

		if ( $code > 0 ) errorHandler( $code, $message, $path, $line, true );
	}
}

set_error_handler( 'errorHandler' );
register_shutdown_function( 'shutdownHandler' );

?>
