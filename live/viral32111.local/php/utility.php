<?php

// Encode data to base64 that is safe to use in URLs
function base64URLEncode( $data ) {
	return rtrim( strtr( base64_encode( $data ), '+/', '-_' ), '=' );
}

// Decode base64 data that was safe to use in URLs
function base64URLDecode( $data ) {
	return base64_decode( str_pad( strtr( $data, '-_', '+/' ), strlen( $data ) % 4, '=', STR_PAD_RIGHT ) );
}

// Returns information about a visitor if they are coming from the Tor network
function fetchVisitorTorInfo( $ip ) {

	// Flip the IP address
	$flipped = implode( '.', array_reverse( explode( '.', $ip ) ) );

	// Perform a TXT record lookup on the Tor DNS servers
	$lookup = dns_get_record( $flipped . '.dnsel.torproject.org', DNS_TXT );

	// Return an array
	return [

		// If the lookup result has more than zero answers, then it is a Tor exit relay!
		'tor' => count( $lookup ) > 0,

		// Populate an array with the fingerprint(s) of the visitor's Tor exit relay
		'fingerprints' => array_map( fn( $answer ) => $answer[ 'txt' ], $lookup )

	];

}

?>
