<?php

// Set GnuPG's data folder
putenv( 'GNUPGHOME=/home/ubuntu2004/github-repositories/viral32111/viral32111.local/gnupg/' );

// Initalise a GnuPG instance
$gpgHandle = gnupg_init();

// My public key's fingerprint
$gpgPublicKeyFPR = '906F25BD726AAE08F5F14E280A993CCFC26A5E2E';

// Read my public key from the '/public.txt' file
//$gpgPublicKeyData = file_get_contents( 'public.txt' );

// Throw an error if importing my public key fails
//if ( gnupg_import( $gpgHandle, $gpgPublicKeyData ) === FALSE ) die( 'Failed to import public key: ' . gnupg_geterror( $gpgHandle ) );

// The template for a content parse result
$template = [

	// The metadata of the page
	'metadata' => [

		// Title
		'title' => 'viral32111\'s website',

		// Description
		'summary' => 'I\'m viral32111, this is my website.',

		// Image
		'thumbnail' => '/img/avatar.png',

		// Edit reason
		'changenote' => NULL

	],

	// The content of the page
	'content' => NULL,

	// The PGP signature of the content
	'signature' => NULL

];

// A helper function to verify PGP clearsigned text
function verifySignature( $clearSignedText ) {

	// Include some global variables in this scope
	global $gpgHandle, $gpgPublicKeyFPR;

	// Placeholder for the original text
	$plainText = '';

	// Verify it
	$verifyResult = gnupg_verify( $gpgHandle, $clearSignedText, FALSE, $plainText );

	// Return null if signature verification failed - this usually means the text is not clearsigned, but do check gnupg_error()
	if ( $verifyResult === FALSE ) return NULL;

	// Return an array
	return [
		
		// True/false depending on if the signature's fingerprint matches the public key fingerprint
		'good' => ( $verifyResult[ 0 ][ 'fingerprint' ] === $gpgPublicKeyFPR ),

		// The original plaintext
		'text' => $plainText

	];

}

// A function to parse a markdown content file to a specific format
function parseContent( $path, $format ) {

	/******** SETUP ********/

	// Include $template into the scope of this function
	global $template;

	/******** CHECKS ********/

	// Don't continue if the file isn't a markdown file
	if ( pathinfo( $path, PATHINFO_EXTENSION ) !== 'md' ) return FALSE;

	// Don't continue if the file doesn't exist
	if ( is_file( $path ) !== TRUE ) return FALSE;

	/******** COPY TEMPLATE ********/

	// Copy the template into a local variable
	$response = $template;

	/******** READ FILE ********/

	// Open the file for reading
	$handle = fopen( $path, 'r' );

	// Read the entire file into a string
	$contents = fread( $handle, filesize( $path ) );

	// Close the file
	fclose( $handle );

	/******** PARSE SIGNATURE ********/

	// Was parsing the signature within the contents of the file successful?
	if ( ( $verifyResult = verifySignature( $contents ) ) !== NULL ) {
		
		// Set the response signature status
		$response[ 'signature' ] = $verifyResult[ 'good' ];

		// Set the content
		$contents = $verifyResult[ 'text' ];

	}

	/******** PARSE METADATA ********/

	// Split the file up every new line
	$lines = explode( "\n", $contents );
	
	// Loop through each line
	foreach ( $lines as $index => $line ) {

		// Placeholder for matched regex groups
		$pair = [];

		// Skip lines that aren't metadata
		if ( preg_match( '/^;([a-z]+)=(.+)$/', $line, $pair ) !== 1 ) continue;

		// Fetch the metadata's key and value pair
		$key = $pair[ 1 ];
		$value = $pair[ 2 ];

		// Add it to the response's metadata
		$response[ 'metadata' ][ $key ] = $value;

		// Remove it from the array
		unset( $lines[ $index ] );

	}

	// Update original file content variable
	$contents = trim( implode( "\n", $lines ) );

	/******** PARSE MARKDOWN ********/

	// Is the requested format markdown?
	if ( $format === 'markdown' ) {

		// Set the markdown
		$response[ 'content' ] = $contents;

	// Is the requested format HTML?
	} elseif ( $format === 'html' ) {

		// Set the HTML
		$response[ 'content' ] = $contents;

	// Is the requested format JSON?
	} elseif ( $format === 'json' ) {

		// Set the JSON
		$response[ 'content' ] = $contents;

	}

	/******** FINALISE ********/

	// Return the final response
	return $response;

}

?>
