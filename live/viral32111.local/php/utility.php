<?php

// Encode data to base64 that is safe to use in URLs
function base64URLEncode( $data ) {
	return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' );
}

// Decode base64 data that was safe to use in URLs
function base64URLDecode( $data ) {
	return base64_decode( str_pad( strtr( $data, '-_', '+/' ), strlen( $data ) % 4, '=', STR_PAD_RIGHT ) );
}

?>
