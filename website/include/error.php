<?php

$statusCodeMessages = [
	403 => 'Forbidden',
	404 => 'Not Found',
	410 => 'Gone',
	500 => 'Internal Server Error',
	501 => 'Not Implemented'
];

function showErrorPage( int $statusCode, string $userMessage = null ) {

	global $statusCodeMessages;

	$errorMessage = $userMessage ?? $statusCodeMessages[ $statusCode ];

	ob_clean();

	http_response_code( $statusCode );

	//$_GET = [ 'error' => $statusCode ];
	//include( '../script/index.php' );

	header( 'Content-Type: text/plain' );

	exit( "HTTP $statusCode\n\n$errorMessage" );

}

function onFatalError( int $errorCode, string $errorMessage, string $sourcePath, int $sourceLine ) : bool {

	error_log( $errorMessage );

	showErrorPage( 500 );

	return true;

}

function onUncaughtException( Throwable $exception ) {

	$errorCode = $exception->getCode();
	$errorMessage = $exception->getMessage();
	$sourcePath = $exception->getFile();
	$sourceLine = $exception->getLine();

	onFatalError( $errorCode, $errorMessage, $sourcePath, $sourceLine );

}

function onShutdown() {

	$lastError = error_get_last();

	if ( is_array( $lastError ) ) {

		$errorCode = $lastError[ "type" ] ?? null;
		$errorMessage = $lastError[ "message" ] ?? null;
		$sourcePath = $lastError[ "file" ] ?? null;
		$sourceLine = $lastError[ "line" ] ?? null;

		onFatalError( $errorCode, $errorMessage, $sourcePath, $sourceLine );
	
	}

}

set_error_handler( "onFatalError" );
set_exception_handler( "onUncaughtException" );

register_shutdown_function( "onShutdown" );

?>
