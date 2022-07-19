<?php

function showErrorPage( int $statusCode, string $userMessage = null ) {

	ob_clean();

	http_response_code( $statusCode );

	//$_SERVER[ 'REDIRECT_STATUS' ] = $statusCode;
	//setenv( "ERROR_USER_MESSAGE", $userMessage );

	include( '../script/error.php' );

	exit();

}

function onFatalError( int $errorCode, string $errorMessage, string $sourcePath, int $sourceLine ) : bool {

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
