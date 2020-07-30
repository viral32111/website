<?php

/****************************************************************
Initalise global variables
****************************************************************/

/******** GNUPG ********/

// Set the GnuPG home directory
putenv( 'GNUPGHOME=' . $_SERVER[ 'CONFIG_GNUPG_HOME' ] );

// Create a GnuPG instance
$gnupg = gnupg_init();

// My public key's fingerprint
$publicKeyFingerprint = '906F25BD726AAE08F5F14E280A993CCFC26A5E2E';

// Throw an error if importing my public key from the '/public.txt' file fails - this only needs to be done once as the keyring is persistent!
//if ( gnupg_import( $gnupg, file_get_contents( 'public.txt' ) ) === FALSE ) die( 'Failed to import public key: ' . gnupg_geterror( $gnupg ) );

/******** ARRAYS ********/

// The template for a content parse result
$template = [

	// The metadata of the page
	'metadata' => [

		// Default title
		'title' => 'viral32111\'s website',

		// Default description
		'summary' => 'I\'m viral32111, this is my website.',

		// Default image
		'thumbnail' => '/img/avatar.png',

		// Default edit reason
		'changenote' => NULL

	],

	// The content of the page
	'content' => NULL,

	// The digital signature of the content
	'signature' => NULL

];

// Available content formats & their parsing functions
$formats = [

	// Plaintext
	'text' => function( $raw, $content, $lines ) {

		// Just return the entire file
		return $raw;

	},

	// HTML
	'html' => function( $raw, $content, $lines ) {

		// Remove empty lines
		$lines = array_filter( $lines, fn( $line ) => !is_null( $line ) && $line !== '' );

		// Return each line as a HTML paragraph
		return '<p>' . implode( '</p><p>', $lines ) . '</p>';
	}

];

/****************************************************************
Define public functions
****************************************************************/

// A function to parse a markdown content file to a specific format
function parseContent( $path, $format ) {

	/******** SETUP ********/

	// Include global variables into the scope of this function
	global $template, $formats, $gnupg, $publicKeyFingerprint;

	/******** CHECKS ********/

	// Don't continue if the requested format isn't recognised
	if ( array_key_exists( $format, $formats ) !== TRUE ) return FALSE;

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
	$content = fread( $handle, filesize( $path ) );
	
	// Create a copy of the file's content
	$raw = $content;

	// Close the file
	fclose( $handle );

	/******** VERIFY SIGNATURE ********/

	// A placeholder for the original text
	$plaintext = '';

	// Was attepting to verify the digital signature successful?
	if ( ( $verifyResult = gnupg_verify( $gnupg, $content, FALSE, $plaintext ) ) !== FALSE ) {

		// True/false depending on if the signature's fingerprint matches the public key fingerprint
		$response[ 'signature' ] = ( $verifyResult[ 0 ][ 'fingerprint' ] === $publicKeyFingerprint );

		// Set the original text
		$content = $plaintext;

	}

	/******** PARSE METADATA ********/

	// Split the file up every new line
	$lines = explode( "\n", $content );

	// Loop through each line
	foreach ( $lines as $index => $line ) {

		// Placeholder for matched regex groups
		$pair = [];

		// Skip lines that aren't metadata
		if ( preg_match( '/^;([a-z]+)=(.+)$/', $line, $pair ) !== 1 ) continue;

		// Add the metadata's key and value pair to the response's metadata
		$response[ 'metadata' ][ $pair[ 1 ] ] = $pair[ 2 ];

		// Remove it from the array
		unset( $lines[ $index ] );

	}

	// Remove the first value of the array if it's an empty string
	if ( reset( $lines ) === '' ) unset( $lines[ key( $lines ) ] );

	// Remove the last value of the array if it's an empty string
	if ( end( $lines ) === '' ) unset( $lines[ key( $lines ) ] );

	// Update original file content variable
	$content = trim( implode( "\n", $lines ) );

	/******** PARSE CONTENT ********/

	$response[ 'content' ] = $formats[ $format ]( $raw, $content, $lines );

	/******** FINALISE ********/

	// Return the final response
	return $response;

}

// A function to parse the HTTP accept header's values
function parseAcceptHeader() {

	// Return null if the header isn't available
	if ( isset( $_SERVER[ 'HTTP_ACCEPT' ] ) !== TRUE ) return NULL;

	// A placeholder to be filled with the sorted mime types
	$accept = [];

	// Loop through each mime type
	foreach ( explode( ',', trim( $_SERVER[ 'HTTP_ACCEPT' ] ) ) as $type ) {

		// Placeholder for the matched regex groups
		$groups = [];

		// Skip this iteration if the mime type doesn't match the regular expression
		if ( preg_match( '/^([A-Za-z0-9\+-\.\*]+\/[A-Za-z0-9\+-\.\*]+)(?>;q=(\d(?>\.\d)?))?$/', trim( $type ), $groups ) !== 1 ) continue;

		// Add the mime type and weight to the array
		$accept[ $groups[ 1 ] ] = floatval( $groups[ 2 ] ?? '1.0' );

	}

	// Sort the array in reverse by value
	arsort( $accept );

	// Return the sorted array if there are values in it, if not then return null
	return count( $accept ) > 0 ? $accept : NULL;

}

?>
