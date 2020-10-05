<?php

$errorMessages = [

	// Informational
	100 => 'Continue',
	101 => 'Switching Protocols',
	102 => 'Processing',
	103 => 'Early Hints',

	// Success
	200 => 'OK',
	201 => 'Created',
	202 => 'Accepted',
	203 => 'Non-Authoritative Information',
	204 => 'No Content',
	205 => 'Reset Content',
	206 => 'Partial Content',
	207 => 'Multi-Status',
	208 => 'Already Reported',
	226 => 'IM Used',

	// Redirection
	300 => 'Multiple Choices',
	301 => 'Moved Permanently',
	302 => 'Found',
	303 => 'See Other',
	304 => 'Not Modified',
	305 => 'Use Proxy',
	306 => 'Switch Proxy',
	307 => 'Temporary Redirect',
	308 => 'Permanent Redirect',

	// Client Errors
	400 => 'Bad Request',
	401 => 'Unauthorized',
	402 => 'Payment Required',
	403 => 'Forbidden',
	404 => 'Not Found',
	405 => 'Method Not Allowed',
	406 => 'Not Acceptable',
	407 => 'Proxy Authentication Required',
	408 => 'Request Timeout',
	409 => 'Conflict',
	410 => 'Gone',
	411 => 'Length Required',
	412 => 'Precondition Failed',
	413 => 'Payload Too Large',
	414 => 'URI Too Long',
	415 => 'Unsupported Media Type',
	416 => 'Range Not Satisfiable',
	417 => 'Expectation Failed',
	418 => 'I\'m a tealpot',
	421 => 'Misdirected Request',
	422 => 'Unprocessable Entity',
	423 => 'Locked',
	424 => 'Failed Dependency',
	425 => 'Too Early',
	426 => 'Upgrade Required',
	428 => 'Precondition Required',
	429 => 'Too Many Requests',
	431 => 'Request Header Fields Too Large',
	451 => 'Unavailable For Legal Reasons',

	// Server Errors
	500 => 'Internal Server Error',
	501 => 'Not Implemented',
	502 => 'Bad Gateway',
	503 => 'Service Unavailable',
	504 => 'Gateway Timeout',
	505 => 'HTTP Version Not Supported',
	506 => 'Variant Also Negotiates',
	507 => 'Insufficient Storage',
	508 => 'Loop Detected',
	510 => 'Not Extended',
	511 => 'Network Authentication Required'

];

$status = $_SERVER[ 'REDIRECT_STATUS' ];
$message = $errorMessages[ $status ];
echo( '<h1>' . $status . ': ' . $message . '</h1>' );

echo( '<pre>' );
echo( 'REDIRECT_STATUS: ' . $_SERVER[ 'REDIRECT_STATUS' ] . "\n" );
echo( 'REDIRECT_REQUEST_METHOD: ' . $_SERVER[ 'REDIRECT_REQUEST_METHOD' ] . "\n" );
echo( 'REDIRECT_SCRIPT_URL: ' . $_SERVER[ 'REDIRECT_SCRIPT_URL' ] . "\n" );
echo( 'REQUEST_URI: ' . $_SERVER[ 'REQUEST_URI' ] . "\n" );
echo( '</pre><hr><pre>' );
var_dump( $_GET );
echo( '</pre><hr><pre>' );
var_dump( $_POST );
echo( '</pre><hr><pre>' );
var_dump( $_COOKIE );
echo( '</pre><hr><pre>' );
var_dump( $_SERVER );
echo( '</pre>' );

?>
