<?php

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
		'changenote' => null,

		// GPG signature
		'signature' => null

	],

	// The content of the page
	'content' => [
	
		// The markdown representation of the page
		'markdown' => '',

		// The HTML representation of the page
		'html' => '',

		// The JSON representation of the page
		'json' => []

	]

];

function parseContent( $path ) {

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

	// DEBUGGING
	$response[ 'raw' ] = $contents;

	// Update original file content variable
	$contents = trim( implode( "\n", $lines ) );

	/******** PARSE CONTENT ********/

	// Placeholder for matched regex groups
	$signature = [];

	// Is this content signed?
	if ( preg_match( '/^-----BEGIN PGP SIGNED MESSAGE-----\nHash: ([A-Za-z0-9]+)\n\n(.*)\n-----BEGIN PGP SIGNATURE-----\n\n([A-Za-z0-9\/\+\=\n]+)\n-----END PGP SIGNATURE-----$/s', $contents, $signature ) === 1 ) {

		// Add it to the response's metadata
		$response[ 'metadata' ][ 'signature' ] = [
			'hash' => $signature[ 1 ],
			'hex' => $signature[ 3 ],
		];

		// Update original file content variable
		$contents = $signature[ 2 ];

	}

	/******** PARSE MARKDOWN ********/

	// Set the markdown
	$response[ 'content' ][ 'markdown' ] = $contents;

	// Set the HTML
	$response[ 'content' ][ 'html' ] = $contents;

	// Set the JSON
	$response[ 'content' ][ 'json' ] = $contents;

	/******** FINALISE ********/

	// Return the final response
	return $response;

}

?>
