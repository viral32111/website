<?php

function generateNonce( int $bytes = 16 ) {
	return bin2hex( openssl_random_pseudo_bytes( 16 ) );
}

function setContentSecurityPolicy( bool $upgradeInsecureRequests ) : array {

	$nonces = [
		"HLJS_STYLE" => generateNonce(),
		"HLJS_SCRIPT" => generateNonce(),
	];

	$contentSecurityPolicy = [
		"default-src 'none'",
		"base-uri 'self'",
		"style-src 'self' 'nonce-" . $nonces[ "HLJS_STYLE" ] . "' 'sha256-FwPDLLk3ItiDGzdbYXDQRcflOk0beRbxGRj0j0RfG+M=' 'sha256-W5EtiT3W5OFrHozYatBNWpbNzRbcX1TLS7gLGYDx4nw=' https://cdnjs.cloudflare.com", // 'sha256-Oppd74ucMR5a5Dq96FxjEzGF7tTw2fZ/6ksAqDCM8GY='
		"script-src 'nonce-" . $nonces[ "HLJS_SCRIPT" ] ."' https://cdnjs.cloudflare.com", // 'sha256-4v2jQZxK6PbZEeZ2xl2ziov6NHMksBFgBlxtMZVYbQk='
		"img-src 'self'",
		"media-src 'self'",
		"frame-ancestors 'none'",
		"form-action 'none'",
		//"require-trusted-types-for 'script'"
	];

	if ( $upgradeInsecureRequests ) array_push( $contentSecurityPolicy, "upgrade-insecure-requests" );

	header( "Content-Security-Policy:" . join( "; ", $contentSecurityPolicy ) . ";" );

	return $nonces;

}

?>
